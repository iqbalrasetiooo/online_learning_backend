<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
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
Route::get('user', [AuthenticationController::class, 'index']);
Route::get('user/{id}', [AuthenticationController::class, 'show']);

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::get('lecturer', [LecturerController::class, 'index']);
Route::post('lecturer/add', [LecturerController::class, 'createLecturer']);

Route::post('course/add', [CourseController::class, 'store']);
Route::post('course/category', [CourseController::class, 'category']);

Route::post('video/add', [VideoController::class, 'store']);
Route::delete('video/delete/{id}', [VideoController::class, 'destroy']);
