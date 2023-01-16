<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('columns', ColumnController::class)->only(['index', 'store', 'destroy']);

Route::controller(CardController::class)
    ->prefix('cards')
    ->group(function (){
    Route::get('/', 'index')->name('cards.index')->middleware('api_auth');
    Route::post('/','store')->name('cards.store');
    Route::post('cards/swap-positions', 'swapPositions')->name('cards.swap-positions');
});
