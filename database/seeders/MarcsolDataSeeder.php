<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Promotion;
use App\Models\Redirect301;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class MarcsolDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Configuraciones Globales: Branding, Data Tracking, SEO
        $settings = [
            // Branding
            ['clave' => 'site_name', 'valor' => 'Marcsol', 'grupo' => 'branding'],
            ['clave' => 'site_tagline', 'valor' => 'Supermercado Corporativo - Ahorro y Calidad en Quevedo', 'grupo' => 'branding'],
            ['clave' => 'primary_color', 'valor' => '#0F4C81', 'grupo' => 'branding'], // Azul corporativo elegante
            ['clave' => 'secondary_color', 'valor' => '#F58220', 'grupo' => 'branding'], // Naranja cálido de retail
            ['clave' => 'accent_color', 'valor' => '#2ECC71', 'grupo' => 'branding'], // Verde frescura
            ['clave' => 'logo_url', 'valor' => '/images/logo.svg', 'grupo' => 'branding'],
            ['clave' => 'favicon_url', 'valor' => '/favicon.ico', 'grupo' => 'branding'],
            ['clave' => 'company_phone', 'valor' => '+593 5 275 9000', 'grupo' => 'branding'],
            ['clave' => 'company_whatsapp', 'valor' => '+593 99 765 4321', 'grupo' => 'branding'],
            ['clave' => 'company_email', 'valor' => 'contacto@marcsol.com.ec', 'grupo' => 'branding'],
            ['clave' => 'company_address', 'valor' => 'Av. 7 de Octubre #402 y Calle Cuarta, Quevedo, Ecuador', 'grupo' => 'branding'],

            // Data Tracking
            ['clave' => 'gtm_id', 'valor' => 'GTM-MARCSOL01', 'grupo' => 'tracking'],
            ['clave' => 'meta_pixel_id', 'valor' => '987654321012345', 'grupo' => 'tracking'],
            ['clave' => 'tiktok_pixel_id', 'valor' => 'C9876543210MARCSOL', 'grupo' => 'tracking'],
            ['clave' => 'clarity_id', 'valor' => 'ms_clarity_quevedo', 'grupo' => 'tracking'],
            ['clave' => 'custom_head_scripts', 'valor' => '<!-- Scripts Corporativos Marcsol -->', 'grupo' => 'tracking'],
            ['clave' => 'custom_body_scripts', 'valor' => '', 'grupo' => 'tracking'],

            // SEO Global
            ['clave' => 'meta_title_default', 'valor' => 'Marcsol | Supermercado Corporativo en Quevedo', 'grupo' => 'seo_global'],
            ['clave' => 'meta_description_default', 'valor' => 'Descubre las mejores ofertas, promociones diarias y variedad de productos en Marcsol Supermercado Corporativo en Quevedo, Los Ríos.', 'grupo' => 'seo_global'],
            ['clave' => 'og_image_default', 'valor' => '/images/og-default.jpg', 'grupo' => 'seo_global'],
            ['clave' => 'schema_type', 'valor' => 'Supermarket', 'grupo' => 'seo_global'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['clave' => $setting['clave']], $setting);
        }

        // 2. Sucursales en Quevedo - Ecuador
        $branches = [
            [
                'nombre' => 'Sucursal Matriz Centro',
                'slug' => 'sucursal-matriz-centro',
                'direccion' => 'Av. 7 de Octubre y Calle Cuarta (Frente al Parque Central)',
                'ciudad' => 'Quevedo',
                'telefono' => '+593 5 275 9001',
                'email' => 'matriz@marcsol.com.ec',
                'mapa_lat' => -1.0254000,
                'mapa_lng' => -79.4642000,
                'horarios' => 'Lunes a Sábado: 07:30 - 21:30 | Domingos: 08:00 - 20:00',
                'imagen' => null,
                'status' => true,
            ],
            [
                'nombre' => 'Sucursal San Camilo',
                'slug' => 'sucursal-san-camilo',
                'direccion' => 'Av. Guayaquil y Calle México, Parroquia San Camilo',
                'ciudad' => 'Quevedo',
                'telefono' => '+593 5 275 9002',
                'email' => 'sancamilo@marcsol.com.ec',
                'mapa_lat' => -1.0315000,
                'mapa_lng' => -79.4580000,
                'horarios' => 'Lunes a Domingo: 07:30 - 21:00',
                'imagen' => null,
                'status' => true,
            ],
            [
                'nombre' => 'Sucursal El Guayacán',
                'slug' => 'sucursal-el-guayacan',
                'direccion' => 'Av. Walter Andrade y Av. Los Álamos (Sector El Guayacán)',
                'ciudad' => 'Quevedo',
                'telefono' => '+593 5 275 9003',
                'email' => 'guayacan@marcsol.com.ec',
                'mapa_lat' => -1.0182000,
                'mapa_lng' => -79.4721000,
                'horarios' => 'Lunes a Sábado: 08:00 - 21:00 | Domingos: 08:00 - 19:30',
                'imagen' => null,
                'status' => true,
            ],
        ];

        $branchModels = [];
        foreach ($branches as $branch) {
            $branchModels[$branch['slug']] = Branch::updateOrCreate(['slug' => $branch['slug']], $branch);
        }

        // 3. Categorías de Productos
        $categories = [
            ['nombre' => 'Carnes y Embutidos', 'slug' => 'carnes-y-embutidos', 'descripcion' => 'Cortes de primera, res, cerdo, pollo y embutidos seleccionados.'],
            ['nombre' => 'Lácteos y Huevos', 'slug' => 'lacteos-y-huevos', 'descripcion' => 'Leches, quesos, yogures y productos lácteos frescos.'],
            ['nombre' => 'Frutas y Verduras', 'slug' => 'frutas-y-verduras', 'descripcion' => 'Productos cosechados directamente de productores locales de Los Ríos.'],
            ['nombre' => 'Abarrotes y Despensa', 'slug' => 'abarrotes-y-despensa', 'descripcion' => 'Arroz, aceites, granos, pastas, conservas y enlatados.'],
            ['nombre' => 'Bebidas y Licores', 'slug' => 'bebidas-y-licores', 'descripcion' => 'Aguas, jugos, refrescos, cervezas y licores nacionales e importados.'],
            ['nombre' => 'Limpieza y Hogar', 'slug' => 'limpieza-y-hogar', 'descripcion' => 'Detergentes, desinfectantes y artículos esenciales del hogar.'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Promociones
        $promotions = [
            [
                'titulo' => '¡Super Ahorro del Día! Pack Lácteo Familiar',
                'slug' => 'super-ahorro-del-dia-pack-lacteo-familiar',
                'descripcion' => 'Aprovecha solo por hoy: Lleva 3 litros de leche entera Toni o La Lechera y obtén el 4to pack al 50% de descuento. ¡Ideal para toda la familia!',
                'imagen' => null,
                'banner' => null,
                'pdf_volante' => null,
                'fecha_inicio' => now()->startOfDay(),
                'fecha_fin' => now()->endOfDay(),
                'es_promocion_del_dia' => true,
                'category_id' => $catModels['lacteos-y-huevos']->id ?? null,
                'sucursal_id' => null, // Aplica a todas las sucursales
                'status' => true,
                'meta_title' => 'Promoción del Día: Pack Lácteo Familiar | Marcsol',
                'meta_description' => 'Ahorra hoy en Marcsol Quevedo con el 50% de descuento en el 4to litro de leche.',
            ],
            [
                'titulo' => 'Miércoles de Parrillada Marcsol',
                'slug' => 'miercoles-de-parrillada-marcsol',
                'descripcion' => 'Todos los miércoles recibe 20% de descuento en costillas de cerdo, lomo fino y cortes para asado con peso garantizado.',
                'imagen' => null,
                'banner' => null,
                'pdf_volante' => null,
                'fecha_inicio' => now()->subDays(2),
                'fecha_fin' => now()->addDays(20),
                'es_promocion_del_dia' => false,
                'category_id' => $catModels['carnes-y-embutidos']->id ?? null,
                'sucursal_id' => $branchModels['sucursal-matriz-centro']->id ?? null,
                'status' => true,
                'meta_title' => 'Miércoles de Parrillada | Cortes de Carne en Quevedo',
                'meta_description' => 'Disfruta de los mejores cortes de carne con 20% de descuento todos los miércoles en Marcsol.',
            ],
            [
                'titulo' => 'Feria de la Huerta Ecuatoriana',
                'slug' => 'feria-de-la-huerta-ecuatoriana',
                'descripcion' => 'Frutas y legumbres frescas con hasta 30% de ahorro directo. Apoya a los agricultores de la provincia de Los Ríos.',
                'imagen' => null,
                'banner' => null,
                'pdf_volante' => null,
                'fecha_inicio' => now()->subDays(1),
                'fecha_fin' => now()->addDays(15),
                'es_promocion_del_dia' => false,
                'category_id' => $catModels['frutas-y-verduras']->id ?? null,
                'sucursal_id' => null,
                'status' => true,
                'meta_title' => 'Feria de Frutas y Verduras | Marcsol Quevedo',
                'meta_description' => 'Frutas y verduras frescas cosechadas en Los Ríos a precios de feria en todas las sucursales Marcsol.',
            ],
            [
                'titulo' => 'Canasta Básica Corporativa',
                'slug' => 'canasta-basica-corporativa',
                'descripcion' => 'Combo de 15 productos esenciales (Arroz, Aceite, Azúcar, Atún, Avena, Pastas) con 18% de ahorro global sobre precio de lista.',
                'imagen' => null,
                'banner' => null,
                'pdf_volante' => null,
                'fecha_inicio' => now()->subDays(5),
                'fecha_fin' => now()->addDays(30),
                'es_promocion_del_dia' => false,
                'category_id' => $catModels['abarrotes-y-despensa']->id ?? null,
                'sucursal_id' => null,
                'status' => true,
                'meta_title' => 'Canasta Básica Corporativa Marcsol | Ahorro en Quevedo',
                'meta_description' => 'Asegura la despensa de tu hogar y empresa con el combo de ahorro corporativo Marcsol.',
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::updateOrCreate(['slug' => $promo['slug']], $promo);
        }

        // 5. Eventos
        $events = [
            [
                'titulo' => 'Gran Festival del Asado y Degustación Quevedeña',
                'slug' => 'gran-festival-del-asado-y-degustacion-quevedena',
                'descripcion' => 'Te invitamos a una tarde llena de sabor y tradición en nuestra sucursal El Guayacán. Clases de parrilla en vivo por maestros asadores, degustaciones gratuitas de embutidos artesanales y música en vivo para compartir en familia.',
                'imagen' => null,
                'fecha_evento' => now()->addDays(7)->setHour(15)->setMinute(0),
                'lugar' => 'Estacionamiento Principal - Sucursal El Guayacán, Quevedo',
                'sucursal_id' => $branchModels['sucursal-el-guayacan']->id ?? null,
                'status' => true,
                'meta_title' => 'Festival del Asado Quevedeño | Evento Marcsol',
                'meta_description' => 'Acompáñanos este fin de semana al festival del asado con música en vivo y degustaciones en Marcsol Quevedo.',
            ],
            [
                'titulo' => 'Ruleta Regalona y Show Infantil de Fin de Mes',
                'slug' => 'ruleta-regalona-y-show-infantil-de-fin-de-mes',
                'descripcion' => 'Por cada $25 en compras en cualquier sección, gira la ruleta y gana canastas de víveres, órdenes de compra y electrodomésticos al instante. Además, show de caritas pintadas y animación para los más pequeños.',
                'imagen' => null,
                'fecha_evento' => now()->addDays(14)->setHour(11)->setMinute(0),
                'lugar' => 'Plaza Central - Sucursal Matriz Centro, Quevedo',
                'sucursal_id' => $branchModels['sucursal-matriz-centro']->id ?? null,
                'status' => true,
                'meta_title' => 'Ruleta Regalona y Show Infantil | Marcsol Quevedo',
                'meta_description' => 'Gana premios instantáneos con tus compras y disfruta en familia con el show infantil en Marcsol Centro.',
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(['slug' => $event['slug']], $event);
        }

        // 6. Páginas CMS con Bloques JSON
        $pages = [
            [
                'titulo' => 'Nosotros',
                'slug' => 'nosotros',
                'status' => true,
                'meta_title' => 'Quiénes Somos | Historia y Compromiso de Marcsol Quevedo',
                'meta_description' => 'Conoce la historia, misión, visión y los valores de Marcsol, el supermercado corporativo preferido por las familias y empresas de Quevedo.',
                'contenido_json_bloques' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'titulo' => 'Nacidos en Quevedo para Servir al Ecuador',
                            'subtitulo' => 'Más de una década brindando calidad, ahorro real y servicio con calidez humana.',
                            'boton_texto' => 'Nuestras Sucursales',
                            'boton_url' => '/sucursales',
                        ],
                    ],
                    [
                        'type' => 'texto_imagen',
                        'data' => [
                            'titulo' => 'Nuestra Historia y Misión',
                            'contenido' => 'Marcsol nació como un emprendimiento local en el corazón comercial de Quevedo, provincia de Los Ríos. Con trabajo constante y la confianza de nuestra gente, nos hemos consolidado como el supermercado corporativo de referencia. Nuestra misión es garantizar el acceso a productos de primera necesidad, perecibles de la más alta calidad y soluciones corporativas para negocios locales, siempre con precios justos y atención personalizada.',
                            'posicion_imagen' => 'derecha',
                        ],
                    ],
                    [
                        'type' => 'texto_imagen',
                        'data' => [
                            'titulo' => 'Compromiso con el Agro y el Empleo Local',
                            'contenido' => 'El 70% de nuestras frutas, legumbres y hortalizas provienen directamente de productores agrícolas de Quevedo, Mocache, Buena Fe y Valencia. Apoyamos el comercio justo y generamos más de 120 fuentes de empleo directo e indirecto en la región fluminense.',
                            'posicion_imagen' => 'izquierda',
                        ],
                    ],
                    [
                        'type' => 'faqs',
                        'data' => [
                            'titulo' => 'Valores que nos Definen',
                            'items' => [
                                ['pregunta' => 'Honestidad y Peso Exacto', 'respuesta' => 'Balanza digital calibrada y precios transparentes sin recargos ocultos.'],
                                ['pregunta' => 'Calidad Garantizada', 'respuesta' => 'Cadena de frío ininterrumpida para carnes, lácteos y perecibles.'],
                                ['pregunta' => 'Servicio al Cliente Excepcional', 'respuesta' => 'Un equipo siempre dispuesto a asistirte con una sonrisa.'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'titulo' => 'Preguntas Frecuentes',
                'slug' => 'faq',
                'status' => true,
                'meta_title' => 'Preguntas Frecuentes | Marcsol Quevedo',
                'meta_description' => 'Resuelve tus dudas sobre formas de pago, compras corporativas, promociones y horarios de atención en Marcsol.',
                'contenido_json_bloques' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'titulo' => 'Centro de Ayuda y Preguntas Frecuentes',
                            'subtitulo' => 'Todo lo que necesitas saber para tus compras en Marcsol.',
                            'boton_texto' => 'Escríbenos por WhatsApp',
                            'boton_url' => 'https://wa.me/593997654321',
                        ],
                    ],
                    [
                        'type' => 'faqs',
                        'data' => [
                            'titulo' => 'Preguntas Frecuentes de Clientes',
                            'items' => [
                                ['pregunta' => '¿Cuáles son las formas de pago aceptadas?', 'respuesta' => 'Aceptamos efectivo, tarjetas de débito y crédito (Visa, Mastercard, Diners, American Express), transferencias bancarias locales y pagos mediante billeteras electrónicas como Deuna.'],
                                ['pregunta' => '¿Tienen ventas corporativas y al por mayor?', 'respuesta' => 'Sí, contamos con un departamento corporativo con listas de precios especiales para restaurantes, hoteles, panaderías y empresas. Contáctanos a contacto@marcsol.com.ec.'],
                                ['pregunta' => '¿Tienen servicio de entrega a domicilio?', 'respuesta' => 'Realizamos despachos a domicilio y corporativos en el perímetro urbano de Quevedo y zonas aledañas.'],
                                ['pregunta' => '¿Cómo me entero de la Promoción del Día?', 'respuesta' => 'Puedes consultar diariamente nuestra web en la sección de Promociones o seguir nuestras redes sociales oficiales.'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'titulo' => 'Políticas de Privacidad',
                'slug' => 'politicas-de-privacidad',
                'status' => true,
                'meta_title' => 'Políticas de Privacidad | Marcsol Supermercado',
                'meta_description' => 'Conoce cómo protegemos y tratamos tus datos personales de acuerdo a la legislación ecuatoriana.',
                'contenido_json_bloques' => [
                    [
                        'type' => 'texto_imagen',
                        'data' => [
                            'titulo' => 'Protección de Datos Personales',
                            'contenido' => 'En Marcsol respetamos y garantizamos la privacidad de la información personal de nuestros clientes en estricto cumplimiento con la Ley Orgánica de Protección de Datos Personales del Ecuador. Los datos recabados en formularios de contacto o registro de clientes frecuentes son utilizados exclusivamente para fines comerciales, de facturación y para brindar información sobre nuestras promociones y beneficios.',
                            'posicion_imagen' => 'derecha',
                        ],
                    ],
                ],
            ],
            [
                'titulo' => 'Términos y Condiciones',
                'slug' => 'terminos-y-condiciones',
                'status' => true,
                'meta_title' => 'Términos y Condiciones | Marcsol',
                'meta_description' => 'Condiciones de uso de nuestro portal web, validez de promociones y políticas de compra.',
                'contenido_json_bloques' => [
                    [
                        'type' => 'texto_imagen',
                        'data' => [
                            'titulo' => 'Condiciones Generales de Uso',
                            'contenido' => 'Las ofertas y promociones mostradas en este portal tienen vigencia según las fechas y horas indicadas o hasta agotar stock disponible en cada sucursal de Quevedo. Las imágenes de productos son de carácter referencial. Marcsol se reserva el derecho de modificar promociones con previa notificación pública.',
                            'posicion_imagen' => 'derecha',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 7. Menú Items (Header y Footer)
        $headerMenus = [
            ['titulo' => 'Inicio', 'url' => '/', 'orden' => 1, 'ubicacion' => 'header'],
            ['titulo' => 'Nosotros', 'url' => '/nosotros', 'orden' => 2, 'ubicacion' => 'header'],
            ['titulo' => 'Promociones', 'url' => '/promociones', 'orden' => 3, 'ubicacion' => 'header'],
            ['titulo' => 'Eventos', 'url' => '/eventos', 'orden' => 4, 'ubicacion' => 'header'],
            ['titulo' => 'Sucursales', 'url' => '/sucursales', 'orden' => 5, 'ubicacion' => 'header'],
            ['titulo' => 'Contacto', 'url' => '/contacto', 'orden' => 6, 'ubicacion' => 'header'],
        ];

        foreach ($headerMenus as $item) {
            MenuItem::updateOrCreate(
                ['url' => $item['url'], 'ubicacion' => 'header'],
                $item
            );
        }

        $footerMenus = [
            ['titulo' => 'Promociones y Ofertas', 'url' => '/promociones', 'orden' => 1, 'ubicacion' => 'footer'],
            ['titulo' => 'Sucursales y Horarios', 'url' => '/sucursales', 'orden' => 2, 'ubicacion' => 'footer'],
            ['titulo' => 'Nuestra Historia', 'url' => '/nosotros', 'orden' => 3, 'ubicacion' => 'footer'],
            ['titulo' => 'Preguntas Frecuentes', 'url' => '/faq', 'orden' => 4, 'ubicacion' => 'footer'],
            ['titulo' => 'Políticas de Privacidad', 'url' => '/politicas-de-privacidad', 'orden' => 5, 'ubicacion' => 'footer'],
            ['titulo' => 'Términos y Condiciones', 'url' => '/terminos-y-condiciones', 'orden' => 6, 'ubicacion' => 'footer'],
        ];

        foreach ($footerMenus as $item) {
            MenuItem::updateOrCreate(
                ['url' => $item['url'], 'ubicacion' => 'footer'],
                $item
            );
        }

        // 8. Redirecciones 301 (Migración desde antiguo sitio WordPress)
        $redirects = [
            ['url_origen' => '/ofertas-semanales', 'url_destino' => '/promociones', 'status' => true],
            ['url_origen' => '/nuestros-locales', 'url_destino' => '/sucursales', 'status' => true],
            ['url_origen' => '/quienes-somos', 'url_destino' => '/nosotros', 'status' => true],
            ['url_origen' => '/contactenos', 'url_destino' => '/contacto', 'status' => true],
        ];

        foreach ($redirects as $r) {
            Redirect301::updateOrCreate(['url_origen' => $r['url_origen']], $r);
        }
    }
}
