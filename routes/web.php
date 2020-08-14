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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'project'], function () {
        Route::get('/', 'ProjectController@index')->name('project');
        Route::get('/create', 'ProjectController@create')->name('project.create');
        Route::post('/store', 'ProjectController@store')->name('project.store');
        Route::get('/edit/{id}', 'ProjectController@edit')->name('project.edit');
        Route::post('/update/{id}', 'ProjectController@update')->name('project.update');
        Route::get('/delete', 'ProjectController@delete')->name('project.delete');
    });

    Route::group(['prefix' => 'task'], function () {
        Route::get('/', 'TasksController@index')->name('task');
        Route::get('/create', 'TasksController@create')->name('task.create');
        Route::post('/store', 'TasksController@store')->name('task.store');
        Route::get('/edit/{id}', 'TasksController@edit')->name('task.edit');
        Route::post('/update/{id}', 'TasksController@update')->name('task.update');
        Route::get('/delete', 'TasksController@delete')->name('task.delete');
        Route::put('/update-position','TasksController@updatePosition')->name('update.task.position');
    });
});
