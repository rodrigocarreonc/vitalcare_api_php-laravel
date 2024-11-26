<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\AuthAdminController;

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
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthAdminController::class,'login']);
    Route::post('logout', [AuthAdminController::class,'logout']);
    Route::post('refresh', [AuthAdminController::class,'refresh']);
    Route::post('me', [AuthAdminController::class,'me']);

});