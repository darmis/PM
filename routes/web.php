<?php

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('register', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);
Route::resource('user', 'UsersController')->middleware('auth');
Route::resource('client', 'ClientsController')->middleware('auth');

Route::resource('project', 'ProjectsController')->middleware('auth');
Route::get('/myProjects', 'ProjectsController@activeUserProjects')->middleware('auth');

Route::resource('task', 'TasksController')->middleware('auth');
Route::get('/myOpenTasks', 'TasksController@activeUserOpenTasks')->middleware('auth');
Route::get('/loadingTasks', 'TasksController@loadingTasks')->middleware('auth');
Route::get('/activeUserTasks', 'TasksController@activeUserTasks')->middleware('auth')->name('activeUserTasks');

Route::resource('calendar', 'CalendarsController')->middleware('auth');
Route::post('/calendar/updateCalendar', 'CalendarsController@updateCalendar')->middleware('auth');
Route::post('/calendar/deleteCalendar', 'CalendarsController@deleteCalendar')->middleware('auth');
Route::post('/calendar/updateDate', 'CalendarsController@updateDate')->middleware('auth');

Route::get('/todos', 'TodosController@index')->middleware('auth');
Route::post('/todo', 'TodosController@store')->middleware('auth');
Route::delete('/todo/{todo}', 'TodosController@destroy')->middleware('auth');

Route::resource('timing', 'TimingsController')->middleware('auth');
Route::get('/addClockIn','TimingsController@addClockIn')->middleware('auth')->name('addClockIn');
Route::get('/addClockOut','TimingsController@addClockOut')->middleware('auth')->name('addClockOut');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/trackNote','NoteController@trackNote')->middleware('auth');
