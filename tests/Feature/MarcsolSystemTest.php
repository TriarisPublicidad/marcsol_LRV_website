<?php

use App\Models\Branch;
use App\Models\Category;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Promotion;
use App\Models\Redirect301;
use App\Models\User;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('home page renders successfully with status 200', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('soft deletes works on core models without permanent deletion', function () {
    $category = Category::create([
        'nombre' => 'Test SoftDelete Category',
        'slug' => 'test-softdelete-cat',
        'status' => true,
    ]);

    $category->delete();

    expect($category->trashed())->toBeTrue();
    expect(Category::withTrashed()->where('id', $category->id)->exists())->toBeTrue();
    expect(Category::where('id', $category->id)->exists())->toBeFalse();
});

test('redirect 301 middleware redirects correctly', function () {
    Redirect301::create([
        'url_origen' => '/antigua-ruta-marcsol',
        'url_destino' => '/promociones',
        'status' => true,
    ]);

    $response = $this->get('/antigua-ruta-marcsol');
    $response->assertRedirect('/promociones');
    $response->assertStatus(301);
});

test('public routes for promotions, events, branches and contact load successfully', function () {
    $this->get('/promociones')->assertStatus(200);
    $this->get('/eventos')->assertStatus(200);
    $this->get('/sucursales')->assertStatus(200);
    $this->get('/contacto')->assertStatus(200);
});

test('unauthenticated users are redirected to filament login', function () {
    $response = $this->get('/admin');
    $response->assertRedirect('/admin/login');
});

test('authenticated admin user can access filament dashboard and resource pages', function () {
    $role = Role::create(['name' => 'SuperAdmin']);
    $user = User::factory()->create([
        'email' => 'admin@marcsol.com.ec',
    ]);
    $user->assignRole($role);

    $this->actingAs($user);

    $this->get('/admin')->assertSuccessful();
    $this->get('/admin/branches')->assertSuccessful();
    $this->get('/admin/categories')->assertSuccessful();
    $this->get('/admin/promotions')->assertSuccessful();
    $this->get('/admin/events')->assertSuccessful();
    $this->get('/admin/menu-items')->assertSuccessful();
    $this->get('/admin/pages')->assertSuccessful();
    $this->get('/admin/redirect301s')->assertSuccessful();
    $this->get('/admin/users')->assertSuccessful();
});

test('application runs in spanish with proper accents and localized labels', function () {
    expect(app()->getLocale())->toBe('es');
    expect(__('auth.failed'))->toBe('Estas credenciales no coinciden con nuestros registros.');
    expect(\App\Filament\Resources\Branches\BranchResource::getModelLabel())->toBe('Sucursal');
    expect(\App\Filament\Resources\Branches\BranchResource::getPluralModelLabel())->toBe('Sucursales');
    expect(\App\Filament\Resources\Categories\CategoryResource::getPluralModelLabel())->toBe('Categorías');
    expect(\App\Filament\Resources\Promotions\PromotionResource::getPluralModelLabel())->toBe('Promociones');
    expect(\App\Filament\Resources\Pages\PageResource::getPluralModelLabel())->toBe('Páginas');
    expect(\App\Filament\Resources\ActivityLogs\ActivityLogResource::getPluralModelLabel())->toBe('Auditoría / Logs');
});
test('homepage renders modular page builder blocks when configured', function () {
    Page::create([
        'titulo' => 'Página Principal',
        'slug' => 'inicio',
        'status' => true,
        'meta_title' => 'Marcsol Quevedo',
        'contenido_json_bloques' => [
            [
                'type' => 'hero',
                'data' => [
                    'titulo' => 'Gran Variedad y Precios Bajos en Quevedo',
                    'subtitulo' => 'Supermercado y distribución mayorista',
                    'cta_texto' => 'Ver Ofertas',
                    'cta_url' => '/promociones',
                ],
            ],
            [
                'type' => 'grid_promociones',
                'data' => [
                    'titulo' => 'Promociones Imperdibles de la Semana',
                    'limite' => 4,
                ],
            ],
            [
                'type' => 'eventos',
                'data' => [
                    'titulo' => 'Noticias y Actividades Marcsol',
                    'limite' => 3,
                ],
            ],
        ],
    ]);

    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Gran Variedad y Precios Bajos en Quevedo');
    $response->assertSee('Promociones Imperdibles de la Semana');
    $response->assertSee('Noticias y Actividades Marcsol');
});

test('pages can be moved to trash and restored', function () {
    $page = Page::create([
        'titulo' => 'Página Temporal',
        'slug' => 'pagina-temporal',
        'status' => true,
    ]);

    $page->delete();

    expect($page->trashed())->toBeTrue();
    expect(Page::onlyTrashed()->where('id', $page->id)->exists())->toBeTrue();

    $page->restore();

    expect($page->trashed())->toBeFalse();
    expect(Page::where('id', $page->id)->exists())->toBeTrue();
});

test('admin can access page edit form with two-tier layout', function () {
    $role = Role::create(['name' => 'SuperAdmin']);
    $user = User::factory()->create([
        'email' => 'admin-editor@marcsol.com.ec',
    ]);
    $user->assignRole($role);

    $page = Page::create([
        'titulo' => 'Políticas de Envíos',
        'slug' => 'politicas-envios',
        'status' => true,
    ]);

    $this->actingAs($user);

    $this->get('/admin/pages/' . $page->id . '/edit')->assertSuccessful();
    $this->get('/admin/activity-logs')->assertSuccessful();
    $this->get('/admin/css-sandbox-editor')->assertSuccessful();
});

test('redirect301 cache is populated and automatically flushed on change', function () {
    Redirect301::clearCache();

    $redirect = Redirect301::create([
        'url_origen' => '/ruta-vieja-oferta',
        'url_destino' => '/promociones',
        'status' => true,
    ]);

    $cached = Redirect301::getCachedMap();
    expect($cached)->toHaveKey('/ruta-vieja-oferta');
    expect($cached['/ruta-vieja-oferta'])->toBe('/promociones');

    $redirect->update(['url_destino' => '/sucursales']);
    $newCached = Redirect301::getCachedMap();
    expect($newCached['/ruta-vieja-oferta'])->toBe('/sucursales');

    $redirect->delete();
    $afterDelete = Redirect301::getCachedMap();
    expect($afterDelete)->not->toHaveKey('/ruta-vieja-oferta');
});

test('pages can extend alternative templates like landing layout', function () {
    $page = Page::create([
        'titulo' => 'Campaña Corporativa B2B',
        'slug' => 'campana-b2b',
        'plantilla' => 'landing',
        'status' => true,
        'contenido_json_bloques' => [
            [
                'type' => 'banner_cta',
                'data' => [
                    'titulo' => 'Únete a la Red Mayorista Marcsol',
                    'boton_texto' => 'Contactar Asesor B2B',
                ],
            ],
        ],
    ]);

    $response = $this->get('/campana-b2b');
    $response->assertStatus(200);
    $response->assertSee('Únete a la Red Mayorista Marcsol');
    $response->assertSee('Contactar Asesor');
});
