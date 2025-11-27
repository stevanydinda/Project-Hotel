<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;

Route::get('/', fn() => view('home'))->name('home');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/signup', fn() => view('auth.signup'))->name('signup');

Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


//  user
Route::middleware('auth')->prefix('/user')->name('user.')->group(function () {
    Route::get('/jenis-kamar', [RoomController::class, 'userIndex'])->name('jenis_kamar');
});

Route::get('/kamar/{room}', [RoomController::class, 'userShow'])->name('user.kamar.show');


// admin
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

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
    Route::prefix('/rooms')->name('rooms.')->group(function(){
        Route::get('/',[RoomController::class,'index'])->name('index');
        Route::get('/create',[RoomController::class,'create'])->name('create');
        Route::post('/store', [RoomController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoomController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [RoomController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoomController::class, 'destroy'])->name('delete');
        Route::get('/export', [RoomController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [RoomController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [RoomController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [RoomController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [RoomController::class, 'datatables'])->name('datatables');
    });
});
