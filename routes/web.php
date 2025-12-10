<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/login', [UserController::class, 'authlogin'])->name('login');
Route::get('/signup', [UserController::class, 'authsignup'])->name('signup');
Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // Halaman utama user
    Route::get('/home', [UserController::class, 'index'])->name('home');

    // Daftar kamar dan booking
    Route::get('/jenis-kamar', [RoomController::class, 'index'])->name('jenis_kamar');
    Route::get('/kamar/{id}/booking', [BookingController::class, 'create'])->name('kamar.booking');
    Route::post('/kamar/{id}/booking', [BookingController::class, 'store'])->name('kamar.booking.store');

    // Riwayat booking user
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/booking/{id}/summary', [BookingController::class, 'summary'])->name('booking.summary');

    //
    Route::get('/booking/{id}/qr', [BookingController::class, 'showQr'])->name('booking.qr');
});


Route::middleware(['auth', 'isAdmin'])->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::get('/bookings/datatables', [BookingController::class, 'datatables'])
        ->name('bookings.datatables');
    Route::get('/bookings/chart',[BookingController::class,'dataChart'])->name('chart');

    // Users
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/export', [UserController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // Rooms
    Route::prefix('/rooms')->name('rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/store', [RoomController::class, 'store'])->name('store');
        Route::get('/datatables', [RoomController::class, 'datatables'])->name('datatables');
    });

    // Bookings
    Route::prefix('/bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create/{room_id}', [BookingController::class, 'adminCreate'])->name('create');
        Route::post('/store', [BookingController::class, 'adminStore'])->name('store');
        Route::get('/{id}', [BookingController::class, 'adminShow'])->name('show');
        Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [BookingController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [BookingController::class, 'destroy'])->name('delete');

        // Status update
        Route::patch('/{id}/status', [BookingController::class, 'updateStatus'])->name('update.status');

        // Admin verify payment (tanpa scan QR)
        Route::post('/{id}/verify-payment', [BookingController::class, 'verifyPaymentAdmin'])->name('verify.payment');
    });

    // Payments
    Route::prefix('/payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
    });
});
