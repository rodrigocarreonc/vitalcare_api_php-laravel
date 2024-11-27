<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaregiverController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('admins',[AdminController::class,'index']);

Route::get('caregivers',[CaregiverController::class,'all']);
Route::get('caregivers/{id}',[CaregiverController::class,'get']);
Route::post('caregivers/register',[CaregiverController::class,'register']);
Route::get('caregivers/update/{id}',[CaregiverController::class,'update']);
Route::get('caregivers/delete/{id}',[CaregiverController::class,'delete']);