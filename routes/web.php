<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::resource('members', MemberController::class);

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/courses/{course}/register', [CourseController::class, 'register'])->name('courses.register');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth.member'])->group(function () {
    Route::resource('subscriptions', SubscriptionController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('courses', CourseController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('reservations', ReservationController::class)->except(['edit', 'update', 'destroy']);
    
    Route::middleware(['admin'])->group(function () {
        // Routes pour les cours
        Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::post('subscriptions/{subscription}/validate', [SubscriptionController::class, 'validateSubscription'])->name('subscriptions.validate');
        Route::post('subscriptions/{subscription}/invalidate', [SubscriptionController::class, 'invalidateSubscription'])->name('subscriptions.invalidate');


        // Routes pour les abonnements
        Route::get('subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
        Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

        // Routes pour les réservations
        Route::get('reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });
});
