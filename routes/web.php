<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resource('tickets', App\Http\Controllers\Admin\TicketController::class)->only(['index', 'create', 'store']);
    
    // Stock
    Route::get('stock/attribuer', [App\Http\Controllers\Admin\StockController::class, 'create'])->name('stock.create');
    Route::post('stock/attribuer', [App\Http\Controllers\Admin\StockController::class, 'store'])->name('stock.store');
    
    // Revendeurs
    Route::get('revendeurs', [App\Http\Controllers\Admin\RevendeurController::class, 'index'])->name('revendeurs.index');

    // Rapports
    Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});

// Routes Revendeur
Route::group(['prefix' => 'reseller', 'as' => 'reseller.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\Reseller\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/sell', [App\Http\Controllers\Reseller\DashboardController::class, 'sell'])->name('sell');
});

