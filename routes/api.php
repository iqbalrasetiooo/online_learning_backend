<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;

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

// Route::get('/user', function (Request $request) {
//     return response()->json($request->user());
// });
Route::get('user', [AuthenticationController::class, 'show']);

Route::post('users', [AuthenticationController::class, 'register']);
Route::get('users', [AuthenticationController::class, 'login']);