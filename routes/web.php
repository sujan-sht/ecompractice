<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialSettingsController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/social_settings', [SocialSettingsController::class, 'index'])->name('social');
    // Route::post('/social_settings', [SocialSettingsController::class, 'store'])->name('socialStore');
    Route::patch('/social_settings/edit/{id}', [SocialSettingsController::class, 'update'])->name('socialUpdate');
    Route::resource('/settings', SiteSettingsController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/categories', CategoryController::class);
});

require __DIR__ . '/auth.php';
