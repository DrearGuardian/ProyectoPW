<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

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

// Rutas para ProductsController
Route::post('/create', [ProductsController::class, 'create']);
Route::get('/products', [ProductsController::class, 'getProducts']);
Route::get('/product/{id}', [ProductsController::class, 'getProduct']);
Route::put('/product/{id}', [ProductsController::class, 'updateProduct']);
Route::delete('/product/{id}', [ProductsController::class, 'delete']);

// Rutas para UsersController
Route::post('/users', [UsersController::class, 'create']);
Route::get('/users', [UsersController::class, 'getUsers']);
Route::get('/users/{id}', [UsersController::class, 'getUser']);
Route::put('/users/{id}', [UsersController::class, 'updateUser']);
Route::delete('/users/{id}', [UsersController::class, 'delete']);
