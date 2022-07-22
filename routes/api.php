<?php

use App\Http\Controllers\Api\Project\ProjectController;
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

Route::prefix('v1')->group(function () {
    Route::controller(ProjectController::class)
    ->group(function () {
        Route::get('projects', 'index');
        Route::get('projects/{id}', 'show');
        Route::get('projects/{id}/users', 'getProjectUsers');
        Route::post('projects', 'store');
        Route::put('projects/{id}', 'update');
        Route::post('projects/add-user', 'attachUsertoProject');
        Route::get('projects/{project_id}/deatach-user/{user_id}', 'detachUserFromProject');
        Route::delete('projects/{id}', 'destroy');
    });
});
