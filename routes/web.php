<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\ManageUser;
use App\Http\Livewire\Category\ManageCategory;

Route::get('/', [HomeController::class, 'home']);

Route::get('/login', Login::class)->name('login');

// Reset Password Routes
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'emailVerify'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');

Route::group(['middleware'=> ['auth']], function () {
    Route::post('/logout', [HomeController::class, 'doLogout'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Dashboard::class)->name('profile');
    Route::get('/users', ManageUser::class)->name('user.manage');
    Route::get('/categories', ManageCategory::class)->name('manage.category');
});
