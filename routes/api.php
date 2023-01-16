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
Route::resource('cards', CardController::class)->only(['index', 'store']);

Route::post('cards/swap-positions', [CardController::class, 'swapPositions']);
