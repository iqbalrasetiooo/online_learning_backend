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

//get all user
Route::get('user', [AuthenticationController::class, 'index']);
//get user by id
Route::get('user/{id}', [AuthenticationController::class, 'show']);
//update user
Route::put('user/{id}', [AuthenticationController::class, 'updateUser']);
//register
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('register/lecturer', [AuthenticationController::class, 'registerLecturer']);
//login
Route::post('login', [AuthenticationController::class, 'login']);
//get all lecturer
Route::get('lecturer', [LecturerController::class, 'index']);
//add lecturer
Route::post('lecturer/add', [LecturerController::class, 'createLecturer']);
//get all course
Route::get('course', [CourseController::class, 'index']);
//get course by id
Route::get('course/{id}', [CourseController::class, 'show']);
//delete course 
Route::delete('course/{id}',[CourseController::class, 'destroy']);
//add course
Route::post('course/add', [CourseController::class, 'store']);
//get categories
Route::get('categories', [CategoryController::class, 'index']);
//add categories
Route::post('course/category', [CategoryController::class, 'addCategory']);

Route::post('video/add', [VideoController::class, 'store']);
Route::delete('video/delete/{id}', [VideoController::class, 'destroy']);
