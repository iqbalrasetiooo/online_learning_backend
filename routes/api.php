<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LecturerController;
use App\Http\Controllers\API\VideoController;

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

Route::post('users', [AuthenticationController::class, 'register']);
Route::post('users', [AuthenticationController::class, 'login']);
