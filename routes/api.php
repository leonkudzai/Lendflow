<?php

use App\Http\Controllers\API\NYTBooksController;
use Illuminate\Http\Request;
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

//Adding v1 for API versioning
//Added rate limiter of 60 per minute
Route::prefix('v1')->group(function () {
   Route::middleware('throttle:api')->get('/bestsellers', [NYTBooksController::class, 'index']);
});
