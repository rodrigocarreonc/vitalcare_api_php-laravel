<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthCaregiverController;

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

Route::get('/caregivers',[CaregiverController::class,'all']);
Route::get('/caregivers/{id}',[CaregiverController::class,'get']);
Route::post('/caregivers',[CaregiverController::class,'create']);
Route::put('/caregivers/update/{id}',[CaregiverController::class, 'update']);
Route::delete('/caregivers/delete/{id}',[CaregiverController::class, 'delete']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin/auth'
], function ($router) {
    Route::post('login', [AuthAdminController::class,'login']);
    Route::post('register', [AuthAdminController::class,'register']);
    Route::post('logout', [AuthAdminController::class,'logout']);
    Route::post('refresh', [AuthAdminController::class,'refresh']);
    Route::get('me', [AuthAdminController::class,'me']);
});


Route::group([
    'middleware' => 'auth:caregivers',
    'prefix' => 'caregiver/auth'
], function ($router) {
    Route::post('login', [AuthCaregiverController::class, 'login']);
    Route::post('logout', [AuthCaregiverController::class, 'logout']);
    Route::post('refresh', [AuthCaregiverController::class, 'refresh']);
    Route::get('me', [AuthCaregiverController::class, 'me']);
});


