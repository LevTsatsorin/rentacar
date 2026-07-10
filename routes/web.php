<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{id}', [CarController::class, 'show'])
    ->whereNumber('id')
    ->name('cars.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::view('/about', 'pages.about')->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('cars/{car}/reservar', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('cars/{car}/reservar', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('reservas', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('reservas/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    Route::get('perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('perfil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('reservas/{booking}/pagar', [PaymentController::class, 'checkout'])->name('payments.checkout');
    Route::post('reservas/{booking}/verificar-pago', [PaymentController::class, 'refresh'])->name('payments.refresh');
});

// Retornos de MercadoPago (fuera de 'auth' para no perder el retorno del checkout;
// la pertenencia de la reserva se valida dentro del controlador vía Auth::id()).
Route::get('pago/exito', [PaymentController::class, 'success'])->name('payments.success');
Route::get('pago/error', [PaymentController::class, 'failure'])->name('payments.failure');
Route::get('pago/pendiente', [PaymentController::class, 'pending'])->name('payments.pending');
Route::post('webhooks/mercadopago', [PaymentController::class, 'webhook'])->name('payments.webhook');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class)->except('show');
    Route::post('posts/{post}/restore', [AdminPostController::class, 'restore'])
        ->name('posts.restore')->withTrashed();
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
});
