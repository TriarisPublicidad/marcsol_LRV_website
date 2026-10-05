# GUÍA DE DESPLIEGUE EN PRODUCCIÓN - MARCSOL
**Supermercado Corporativo | Quevedo - Ecuador**

---

## 1. REQUISITOS DEL SERVIDOR (cPanel / Hostinger / LiteSpeed / Apache)

- **PHP:** Versión 8.2 o superior (8.2 / 8.3 / 8.4 recomendadas).
- **Extensiones PHP obligatorias:**
  - `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` (o `imagick`), `zip`, `intl`.
- **Base de Datos:** MySQL 8.0+ o MariaDB 10.4+.
- **Servidor Web:** Apache 2.4+ o LiteSpeed Enterprise con los módulos:
  - `mod_rewrite`, `mod_deflate`, `mod_expires`, `mod_headers`, `mod_negotiation`.
- **Node.js:** **NO es requerido en el servidor de producción**. Todos los assets de Vite (Tailwind CSS, Alpine.js, iconos) se compilan previamente y se distribuyen listos en `public/build/`.

---

## 2. ARQUITECTURA DE ARCHIVOS Y MÉTODOS DE SUBIDA

Existen dos formas estándar de desplegar en hosting compartido:

### Método A: Estructura Segura con DocumentRoot Separado (Recomendado)

En cPanel / Hostinger, la raíz pública suele ser `public_html/`. Por seguridad y aislamiento del código fuente:

1. Coloca el código fuente de Laravel en un directorio privado fuera de la web raíz, por ejemplo:
   ```text
   /home/usuario/marcsol/
   ```
2. Si el hosting te permite configurar el **DocumentRoot** del dominio (ej. en Hostinger o dominios adicionales en cPanel), configúralo para que apunte directamente a:
   ```text
   /home/usuario/marcsol/public
   ```
3. Si el hosting **NO permite cambiar el DocumentRoot** de la cuenta principal:
   - Sube todo el proyecto a `/home/usuario/marcsol/`.
   - Mueve únicamente el contenido de `/home/usuario/marcsol/public/` directamente dentro de `/home/usuario/public_html/`.
   - Edita `/home/usuario/public_html/index.php` ajustando las rutas relativas al autoload y bootstrap:
     ```php
     require __DIR__ . '/../marcsol/vendor/autoload.php';
     $app = require_once __DIR__ . '/../marcsol/bootstrap/app.php';
     ```

### Método B: Despliegue con Raíz en `public_html` mediante `.htaccess`

Si decides subir todo el proyecto directamente dentro de `public_html/`:
1. El proyecto ya incluye un archivo `.htaccess` en la raíz que:
   - Redirige de forma transparente y segura todo el tráfico a la carpeta `/public/`.
   - Bloquea cualquier descarga directa de archivos sensibles (`.env`, `.git`, `composer.json`, carpetas `app/`, `storage/`, etc.).
2. El archivo `public/.htaccess` gestiona la compresión GZIP, la caché de navegador inmutable (1 año) y las cabeceras de seguridad (`X-Frame-Options`, `X-Content-Type-Options`).

### Subida vía SSH / Git o Archivo ZIP:
- **Vía Git (SSH):**
  ```bash
  cd /home/usuario
  git clone https://github.com/TriarisPublicidad/marcsol_LRV_website.git marcsol
  cd marcsol
  composer install --no-dev --optimize-autoloader
  ```
- **Vía ZIP (cPanel Administrador de Archivos):**
  - Comprime localmente la carpeta del proyecto (asegúrate de incluir `public/build` y `vendor` si tu hosting no cuenta con SSH/Composer).
  - Sube el archivo `.zip` mediante el Administrador de Archivos de cPanel y extráelo.

---

## 3. CONFIGURACIÓN DE BASE DE DATOS Y ENTORNO (.env)

1. En cPanel, ingresa al **Asistente de Bases de Datos MySQL**:
   - Crea una base de datos (ejemplo: `usuario_marcsol_db`).
   - Crea un usuario de base de datos (ejemplo: `usuario_marcsol_usr`) con una contraseña segura.
   - Asigna el usuario a la base de datos otorgando **TODOS LOS PRIVILEGIOS**.

2. Crea y configura el archivo `.env` en la raíz del proyecto:
   ```dotenv
   APP_NAME="Marcsol"
   APP_ENV=production
   APP_KEY=base64:GENERA_TU_KEY_AQUI
   APP_DEBUG=false
   APP_URL=https://tudominio.com.ec

   APP_LOCALE=es
   APP_FALLBACK_LOCALE=es
   APP_FAKER_LOCALE=es_ES

   LOG_CHANNEL=daily
   LOG_LEVEL=error

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=usuario_marcsol_db
   DB_USERNAME=usuario_marcsol_usr
   DB_PASSWORD="TuContraseñaSegura2026!"

   BROADCAST_CONNECTION=null
   CACHE_STORE=file
   FILESYSTEM_DISK=public
   QUEUE_CONNECTION=sync
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   ```

3. Genera la llave de cifrado de la aplicación:
   ```bash
   php artisan key:generate --force
   ```

4. Ejecuta las migraciones y seeders iniciales:
   ```bash
   php artisan migrate --seed --force
   ```
   *(Nota: Si ejecutas en producción, el flag `--force` es indispensable para autorizar la ejecución no interactiva).*

---

## 4. PERMISOS DE ARCHIVOS Y STORAGE LINK

1. Asigna permisos de escritura a las carpetas dinámicas de Laravel:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. Crea el enlace simbólico del disco de almacenamiento público:
   ```bash
   php artisan storage:link
   ```
   *(En caso de no contar con SSH, puedes crear una tarea Cron en cPanel de ejecución única con el comando `php /home/usuario/marcsol/artisan storage:link`)*.
3. Verifica que la carpeta `storage/app/public/.htaccess` exista (ya creada por el proyecto) para impedir la ejecución de scripts PHP/CGI en imágenes subidas por usuarios.

---

## 5. COMANDOS DE OPTIMIZACIÓN DE PRODUCCIÓN

Ejecuta los siguientes comandos para maximizar la velocidad de respuesta, reducir consumo de RAM y habilitar la caché de Filament:

```bash
# 1. Cachear configuración de Laravel
php artisan config:cache

# 2. Cachear árbol de rutas
php artisan route:cache

# 3. Pre-compilar todas las vistas Blade
php artisan view:cache

# 4. Cachear componentes de FilamentPHP
php artisan filament:cache-components

# O ejecutar el comando unificado:
php artisan optimize
```

> **Nota para futuros despliegues:** Cada vez que actualices el código fuente en producción, ejecuta:
> ```bash
> php artisan optimize:clear
> php artisan migrate --force
> php artisan optimize
> ```

---

## 6. MODIFICACIONES DE EMERGENCIA EN PRODUCCIÓN

### A. Modificaciones de CSS / Estilos sin re-compilar (Sandbox CSS)
Si necesitas cambiar colores, tamaños, ajustar un banner o corregir un detalle visual de inmediato sin tener que compilar con Vite:
1. Accede al panel administrativo `/admin` con credenciales de **Administrador**.
2. Dirígete a **SEO & Sistema > Editor CSS (Sandbox)**.
3. Edita las reglas CSS en el editor y guarda los cambios.
4. Estas reglas se guardan de forma aislada y segura en `public/css/custom-override.css` y se inyectan automáticamente en el layout público con busteo de caché automático (`?v=timestamp`).

### B. Procedimiento de Recuperación de Registros Eliminados (SoftDeletes)
Por arquitectura y política de seguridad de Marcsol, **ningún registro se elimina físicamente de la base de datos** (`forceDelete` está bloqueado). Si un usuario u operador borra accidentalmente una promoción, evento, sucursal o categoría:

1. **Identificar registros eliminados:**
   ```sql
   -- Ver promociones eliminadas:
   SELECT id, titulo, fecha_inicio, fecha_fin, deleted_at FROM promotions WHERE deleted_at IS NOT NULL;

   -- Ver sucursales eliminadas:
   SELECT id, nombre, direccion, deleted_at FROM branches WHERE deleted_at IS NOT NULL;

   -- Ver eventos eliminados:
   SELECT id, titulo, fecha_evento, deleted_at FROM events WHERE deleted_at IS NOT NULL;
   ```

2. **Restaurar un registro específico:**
   ```sql
   -- Restaurar una promoción:
   UPDATE promotions SET deleted_at = NULL WHERE id = 5;

   -- Restaurar una sucursal:
   UPDATE branches SET deleted_at = NULL WHERE id = 2;

   -- Restaurar un evento:
   UPDATE events SET deleted_at = NULL WHERE id = 3;
   ```

3. **Restauración vía Artisan Tinker (CLI):**
   ```bash
   php artisan tinker
   ```
   ```php
   \App\Models\Promotion::onlyTrashed()->find(5)->restore();
   \App\Models\Branch::onlyTrashed()->find(2)->restore();
   \App\Models\Event::onlyTrashed()->find(3)->restore();
   ```

### C. Modo Mantenimiento con Acceso Secreto
Si requieres pausar el sitio al público para realizar tareas críticas en el servidor:
```bash
# Activar mantenimiento permitiendo acceso a administradores mediante bypass:
php artisan down --secret="marcsol-mantenimiento-2026"

# Acceder con la URL de bypass:
# https://tudominio.com.ec/marcsol-mantenimiento-2026

# Desactivar mantenimiento cuando finalices:
php artisan up
```

---

## 7. CREDENCIALES INICIALES DE ACCESO AL SISTEMA

- **URL del Panel de Administración:** `https://tudominio.com.ec/admin`
- **URL del Portal Web Público:** `https://tudominio.com.ec/`

| Rol | Correo Electrónico | Contraseña Inicial | Alcance de Permisos |
| :--- | :--- | :--- | :--- |
| **SuperAdmin** | `admin@marcsol.com.ec` | `Marcsol2026!` | Acceso total, gestión de roles/permisos, logs de auditoría y configuración general. |
| **Administrador** | `gerente@marcsol.com.ec` | `Marcsol2026!` | Gestión completa de CMS, Promociones, Sucursales, Eventos y Editor CSS Sandbox. |
| **Supervisor** | `supervisor@marcsol.com.ec` | `Marcsol2026!` | Edición y visualización de promociones, eventos y revisión de contenidos. |
| **Operador** | `operador@marcsol.com.ec` | `Marcsol2026!` | Creación y actualización de promociones diarias y horarios de sucursales. |

*Recomendación de Seguridad:* Cambiar las contraseñas predeterminadas inmediatamente después del primer inicio de sesión en el entorno de producción.
