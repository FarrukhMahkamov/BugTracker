<?php

use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Ticket\TicketController;
use App\Http\Controllers\Api\Ticket\TicketStatusController;
use App\Http\Controllers\Api\Ticket\TicketTagController;
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

    Route::controller(TicketController::class)
    ->group(function () {
        Route::get('tickets', 'index');
        Route::get('tickets/{id}', 'show');
        Route::post('tickets', 'store');
        Route::put('tickets/{id}', 'update');
        Route::post('tickets/{id}/attach-users', 'attachUsersToTicket');
        Route::post('tickets/{id}/detach-users', 'detachUserFromTicket');
        Route::post('tickets/{id}/attach-ticket-statuses', 'attachStatusToTicket');
        Route::post('tickets/{id}/detach-ticket-statuses', 'detachTicketStatusFromTicket');
        Route::delete('tickets/{id}', 'destroy');
    });

    Route::controller(TicketStatusController::class)
    ->group(function () {
        Route::get('ticket-statuses', 'index');
        Route::post('ticket-statuses', 'store');
        Route::put('ticket-statuses/{id}', 'update');
        Route::delete('ticket-statuses/{id}', 'destroy');
    });

    Route::controller(TicketTagController::class)
    ->group(function () {
        Route::get('ticket-tags', 'index');
        Route::post('ticket-tags', 'store');
        Route::put('ticket-tags/{id}', 'update');
        Route::delete('ticket-tags/{id}', 'destroy');
    });
});
