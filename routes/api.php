<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
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

//route group, yang harus login terlebih dahulu jika ingin menjalankan route di dalam group ini
Route::middleware('auth:sanctum')->group(function(){
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::post('checkout', [TransactionController::class, 'checkout']);

    Route::get('transaction', [TransactionController::class, 'all']);
    Route::post('transaction/{id}', [TransactionController::class, 'update']);


});

//noted cara bacanya:
//Route methode ('nama route', [Nama Controller, 'nama fungsi di dalam controller']);
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('program', [ProgramsController::class, 'all']);
Route::get('news', [NewsController::class, 'all']);
Route::post('midtrans/callback', [MidtransController::class, 'callback']); 
