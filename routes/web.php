<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\SecurityController::class, 'LogOnPage'])->name('LogOnPage');

Route::get('/index', [App\Http\Controllers\MainPageController::class, 'LoadMainPage'])->name('index');


/*страница с ошибками (пустая)*/
Route::get('/error',function () {
    return view('/ese/error');
})->name('error');

/*Страница авторизации*/
Route::get('/login', [App\Http\Controllers\SecurityController::class, 'LogOnPage'])->name('LogOnPage');


Route::get('/User/{userId}', [App\Http\Controllers\UserController::class, 'UserPage'])->name('UserPage');



/*
ESE/TEST/
*/

/* ESE/SDK/TEST/diagrammer */
Route::get('ESE/TEST/diagrammer',function () {
    return view('/test/diagrammer_test');
})->name('diagrammerTest');


//Тест контекста процесса
Route::get('ESE/TEST/CONTEXT',function () {
    return view('/test/context_test')->with('currentFormId',1);
})->name('contextTest');

/* ESE/SDK/TEST/layout */
Route::get('ESE/TEST/layout',function () {
    return view('/ese/layout');
})->name('layoutTest');
Route::get('ESE/TEST/LDAP', [App\Http\Controllers\IntegrationLDAPController::class, 'Test'])->name('IntegrationLDAPController'); //ViewTickets

/*
ESE/SDK
*/

Route::get('Files/GetFile/{fileid}', [App\Http\Controllers\FileController::class, 'GetFile'])->name('GetFile'); 

/* ESE/SDK/Process/Map?id= */

/* ESE/SDK/Process/Start?id= */

/*Процессы*/
/* Process/{id}/ */
/* Process/{id}/tasks */
/* Process/{id}/history
/* ProcessTask/{id} */

/*Базовые задачи*/
/* Task/{id} */
Route::get('/Task/{id}', [App\Http\Controllers\TaskBase::class, 'TaskBaseView'])->name('TaskBaseView'); //ViewTickets
/* Tasks*/
Route::get('/Tasks', [App\Http\Controllers\TasksController::class, 'TasksPage'])->name('Tasks'); //ViewTickets

/*Пользовательские страницы*/
Route::get('/UIPage/{pagepath}', [App\Http\Controllers\UIPageController::class, 'PageView'])->name('UIPageView'); //ViewTickets
Route::get('/DevStudio/EditUIPage/{pagepath}', [App\Http\Controllers\UIPageController::class, 'EditPage'])->name('DevStudioEditUIPage');

/*Виджеты*/
Route::get('/UIWidget/{widgetpath}', [App\Http\Controllers\UIWidgetController::class, 'WidgetView'])->name('UIWidgetPreviewView'); //ViewTickets
Route::get('/DevStudio/EditUIWidget/{widgetpath}', [App\Http\Controllers\UIWidgetController::class, 'EditWidget'])->name('DevStudioEditUIWidget');

/*Отчеты*/
Route::get('/DevStudio/EditUIReport/{reportid}', [App\Http\Controllers\UIReportController::class, 'EditReport'])->name('DevStudioEditUIReport');
Route::get('/UIReport/{reportid}',[App\Http\Controllers\UIReportController::class,'ViewReport'])->name('ViewReport');


/*Контрагент*/
/* Contractor/{id} */

/*Админ панель*/
/* /Admin/ */
Route::get('admin',function () {
    return view('/ese/admin/panel');
})->name('adminpanel');

/* admin/users */ 
Route::get('admin/users',[App\Http\Controllers\AdminPanelController::class,'AllUsersPage'])->name('adminpanelallusers');
/* admin/users/create */
/* admin/users/edit/{id} */

/* /WebDesigner/ */
Route::get('DevStudio',function () {
    return view('/ese/designer/index');
})->name('DevStudioIndex');

Route::get('/DevStudio/UIReports/', [App\Http\Controllers\DesignerController::class, 'AllUIReports'])->name('DevStudioReportsIndex');
Route::get('/DevStudio/UIPages/', [App\Http\Controllers\DesignerController::class, 'AllUIPages'])->name('DevStudioPagesIndex');

