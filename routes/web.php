<?php

use App\Http\Controllers\Admin\AdminAwardController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    return Inertia('Test', ["name" => "ali"]);
})->name("test");

Route::prefix('admin')->middleware(['auth', 'verified'])->group(
    function () {
        Route::get("/", function () {
            return Inertia::rend("Dashboard");
        });

        Route::prefix('user')
            ->controller(AdminUserController::class)
            ->name('admin.users.')
            ->group(function () {
                Route::get("/profile", 'profile')->name('profile');
                Route::post("/", 'store')->name('store');
                Route::get("/", 'index')->name('index');
                Route::get("/{id}", 'view')->name('view');
                Route::get("/{id}/edit", 'edit')->name('edit');
                Route::delete("/{id}", 'remove')->name('remove');
            });

        Route::prefix('award')
            ->controller(AdminAwardController::class)
            ->name('admin.award.')
            ->group(function () {
                Route::get("/", 'index')->name('index');
                Route::post("/", 'store')->name('store');
            });
    }
);

Route::get('/settings', function () {
    return Inertia::render('Setting/Index');
});
Route::get('/comments', function () {
    return Inertia::render('Comment/Index');
});
Route::get('/orders', function () {
    return Inertia::render('Order/Index');
});

Route::post('/logout', function () {
    dd('logout');
});

require __DIR__ . '/auth.php';
