<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PlanController;

use App\Http\Controllers\Client\StatusClientController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Task\StatusTaskController;
use App\Http\Controllers\Product\TypeProductController;
use App\Http\Controllers\Folio\FolioController;

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

// Route::middleware('auth:sanctum')->get('/usuarios', [UsuarioController::class, 'getUser']);


Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/login-app', [LoginController::class, 'login']);
    Route::get('/getModules', [ModulesController::class, 'getModules']);

    Route::group(['prefix' => 'statusClient'], function(){
        Route::post('newStatusClient', [StatusClientController::class, 'newStatus']);
        Route::get('getStatusClient', [StatusClientController::class, 'getStatus']);
        Route::post('updateStatusClient', [StatusClientController::class, 'updateStatus']);
        Route::post('deleteStatusClient', [StatusClientController::class, 'deleteStatus']);
    });
    Route::group(['prefix' => 'client'], function(){
        Route::post('newClient', [ClientController::class, 'newClient']);
        Route::get('getClients', [ClientController::class, 'getClienteCompany']);
        Route::post('disabledClient', [ClientController::class, 'disabledClient']);
        Route::post('updateClient', [ClientController::class, 'updateClient']);
        Route::post('deleteClient', [ClientController::class, 'deleteClient']);
    });
    Route::group(['prefix' => 'statusTask'], function(){
        Route::post('newStatusTask', [StatusTaskController::class, 'newStatus']);
        Route::get('getStatusTask', [StatusTaskController::class, 'getStatus']);
        Route::post('updateStatusTask', [StatusTaskController::class, 'updateStatus']);
        Route::post('deleteStatusTask', [StatusTaskController::class, 'deleteTask']);
    });
    Route::group(['prefix' => 'typeProduct'], function(){
        Route::post('newTypeProduct', [TypeProductController::class, 'newType']);
        Route::get('getTypeProduct', [TypeProductController::class, 'getType']);
        Route::post('updateTypeProduct', [TypeProductController::class, 'updateType']);
        Route::post('deleteTypeProduct', [TypeProductController::class, 'deleteType']);
    });
    Route::group(['prefix' => 'foliosCompany'], function(){
        Route::get('getFolios',[FolioController::class, 'getFolioCompany']);
        Route::post('updateFolio', [FolioController::class, 'updateFolio']);
    });
});

Route::group(['prefix' => 'panel', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/login-panel', [LoginController::class, 'loginPanel']);
    Route::group(['prefix' => 'user'], function(){
        Route::get('get-users', [UsuarioController::class, 'getUsers']);
        Route::post('new-user', [UsuarioController::class, 'newUser']);
        Route::post('update-user',[UsuarioController::class, 'updateUser']);
        Route::post('delete-user', [UsuarioController::class, 'deleteUser']);
        Route::get('get-userbyid', [UsuarioController::class, 'getUserById']);
    });
    Route::group(['prefix' => 'company'], function(){
        Route::post('new-company', [CompanyController::class, 'newCompany']);
        Route::get('get-companys', [CompanyController::class, 'getCompanys']);
        Route::post('delete-company', [CompanyController::class, 'deleteCompany']);
        Route::post('update-company', [CompanyController::class, 'updateCompany']);
    });
    Route::group(['prefix' => 'plan'], function(){
        Route::post('new-plan', [PlanController::class, 'newPlan']);
        Route::get('get-plans', [PlanController::class, 'getPlans']);
        Route::post('update-plan', [PlanController::class, 'updatePlan']);
        Route::post('save-sale-plan', [PlanController::class, 'saveSalePlan']);
        Route::get('get-eraser-plan', [PlanController::class, 'getEraserPlan']);
        Route::post('delete-eraser-sale', [PlanController::class, 'deleteEraserSale']);
    });
});