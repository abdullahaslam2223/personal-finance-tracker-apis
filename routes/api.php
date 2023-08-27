<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('category', CategoryController::class);
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('transaction', TransactionController::class);
});

Route::middleware('auth:sanctum')->get('chart-transactions', [TransactionController::class, 'getChartTransactions']);

Route::middleware('auth:sanctum')->get('budget', [BudgetController::class, 'getBudget']);