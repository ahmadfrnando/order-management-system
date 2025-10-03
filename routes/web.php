<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananRiwayatController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/orders', [HomeController::class, 'store'])->name('store');

Route::get('/coffee', function () {
    return Inertia::render('Coffee');
})->name('coffee');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // dashboard pesanan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pesanan/{id}', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/dashboard/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::patch('/dashboard/pesanan/{id}/update', [PesananController::class, 'update'])->name('pesanan.update');
    Route::post('/dashboard/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

    //riwayat pesanan
    Route::resource('/pesanan/riwayat', PesananRiwayatController::class)->only(['index', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
