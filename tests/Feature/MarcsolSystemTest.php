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
