<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Marcsol Supermercado Corporativo
|--------------------------------------------------------------------------
*/

// Portada / Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Módulo Comercial: Promociones
Route::get('/promociones', [PromotionController::class, 'index'])->name('promotions.index');
Route::get('/promociones/{slug}', [PromotionController::class, 'show'])->name('promotions.show');

// Módulo de Eventos y Activaciones
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/eventos/{slug}', [EventController::class, 'show'])->name('events.show');

// Directorio de Sucursales en Quevedo
Route::get('/sucursales', [BranchController::class, 'index'])->name('branches.index');
Route::get('/sucursales/{slug}', [BranchController::class, 'show'])->name('branches.show');

// Contacto y Ventas Corporativas (con Throttling de seguridad)
Route::get('/contacto', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contacto', [ContactController::class, 'submit'])->middleware('throttle:6,1')->name('contact.submit');

// Renderizado de Páginas Dinámicas CMS (Wildcard para slugs creados en Admin)
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin|livewire|storage|css|js|images|favicon).*$')
    ->name('pages.show');
