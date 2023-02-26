<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkedController;
use App\Http\Controllers\PaymentController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/link-bank-account/{phone_number}', [LinkedController::class, 'index']);
    Route::resource( '/link-bank-account', LinkedController::class);
    Route::get( '/get-linked/{phone_number}', [ LinkedController::class, 'getLinked']);

    Route::resource('/payments/{phone_number}', PaymentController::class);

});
    

Route::post('/register', [AuthController::class,'register']);
Route::post('/fake-otp', [AuthController::class,'fakeOTPCode']);
Route::post('/check-phone-number', [AuthController::class,'checkOTPCode']);
Route::post('/login', [AuthController::class,'login']);


// Route::get('/test', [AuthController::Class, 'test']);

// Route::get('/get-all-user', [AuthController::Class, 'listUser']);