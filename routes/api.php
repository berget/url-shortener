<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * 路由用於縮短給定的網址。
 *
 * 這個路由接受一個 POST 請求，並返回一個縮短後的網址。
 *
 * @author James
 * @version 1.0.0
 * @since 2024-09-01
 */
Route::post('/shorten', [\App\Http\Controllers\ShortenerUrlController::class, 'shorten']);

/**
 * 根據短碼進行重定向的路由。
 *
 * 這個路由接受一個 GET 請求，並根據給定的短碼將用戶重定向到原始網址。
 *
 * @author James
 * @version 1.0.0
 * @since 2024-09-01
 */
Route::get('/{short_code}', [\App\Http\Controllers\ShortenerUrlController::class, 'redirect']);

/**
 * 查詢短碼資訊的路由。
 *
 * 這個路由接受一個 GET 請求，並返回與給定短碼相關的元數據或資訊。
 *
 * @author James
 * @version 1.0.0
 * @since 2024-09-01
 */
Route::get('/lookup/{short_code}', [\App\Http\Controllers\ShortenerUrlController::class, 'lookup']);
