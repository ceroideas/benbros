<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackendController;
use App\Http\Controllers\PermissionsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getPermissionTemplate', [PermissionsController::class, 'getPermissionTemplate']);
Route::get('getTemplatePermissionEdit/{id}', [PermissionsController::class, 'getTemplatePermissionEdit']);


Route::get('imageTest', [PermissionsController::class, 'imageTest']);

Route::post('generateNotifications', [BackendController::class,'generateNotifications']);


Route::post('uploadXML', [BackendController::class,'uploadXML']);