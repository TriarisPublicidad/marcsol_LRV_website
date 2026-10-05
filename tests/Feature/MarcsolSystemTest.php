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


