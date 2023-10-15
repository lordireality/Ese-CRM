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

Route::get('/ESE/USERS/UserInfo', [App\Http\Controllers\UserController::class, 'API_UserInfo']);
Route::get('/ESE/USERS/AllUsers', [App\Http\Controllers\UserController::class, 'API_GetAllUsers']);

Route::post('/auth', [App\Http\Controllers\SecurityController::class, 'Auth']);


Route::get('ESE/OrganizationItems/GetAllPositions', [App\Http\Controllers\OrganizationItemController::class, 'GetAllPositions'])->name('GetAllPositions'); 
Route::get('ESE/OrganizationItems/BuildTree', [App\Http\Controllers\OrganizationItemController::class, 'BuildTree'])->name('BuildTree'); 

/*Задачи */
Route::post('/ESE/TASKS/AddComment', [App\Http\Controllers\TaskBase::class, 'TaskBaseAddComment']);
Route::post('/ESE/TASKS/CreateTask', [App\Http\Controllers\TaskBase::class, 'TaskBaseCreate']);
Route::post('/ESE/TASKS/ChangeExecutor', [App\Http\Controllers\TaskBase::class, 'TaskBaseChangeExecutor']);
Route::post('/ESE/TASKS/CreateSubTask', [App\Http\Controllers\TaskBase::class, 'SubTaskBaseCreate']);
Route::post('/ESE/TASKS/CloseTask', [App\Http\Controllers\TaskBase::class, 'TaskBaseCloseTask']);
Route::post('/ESE/TASKS/ReopenTask ', [App\Http\Controllers\TaskBase::class, 'TaskBaseReopenTask']);

/*Designer*/
/*Сборка Assembly страницы*/
Route::post('ESE/WEBDESIGNER/PAGECOMPILE', [App\Http\Controllers\UIPageController::class, 'CompilePageSource']);
/*Сборка Assembly виджета*/
Route::post('ESE/WEBDESIGNER/WIDGETCOMPILE', [App\Http\Controllers\UIWidgetController::class, 'CompileWidgetSource']);


/*Добавление зоны виджета на главную страницу*/
Route::post('ESE/MainPage/AddWidgetZone', [App\Http\Controllers\MainPageController::class, 'AddWidgetZone']);
Route::post('ESE/MainPage/SetWidgetToZone', [App\Http\Controllers\MainPageController::class, 'SetWidgetToZone']);
Route::post('ESE/MainPage/RemoveWidgetZone', [App\Http\Controllers\MainPageController::class, 'RemoveWidgetZone']);

/*получение всех доступных виджетов*/
Route::get('ESE/Widgets/GetAllWidgets', [App\Http\Controllers\UIWidgetController::class, 'GetAllWidgets']);

Route::get('ESE/AllTablesTest',[App\Http\Controllers\UIReportController::class,'getAllTables']);