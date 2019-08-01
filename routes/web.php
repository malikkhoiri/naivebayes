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
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/question', 'QuestionController@index');
Route::post('/question/upload', 'QuestionController@upload')->name('uploadQuestion');
Route::get('/question/download/{id}', 'QuestionController@download')->name('downloadQuestion');
Route::get('/question/delete/{id}', 'QuestionController@destroy')->name('deleteQuestion');

Route::get('/answer', 'AnswerController@index');
Route::post('/answer/upload', 'AnswerController@upload')->name('uploadAnswer');
Route::get('/answer/download/{id}', 'AnswerController@download')->name('downloadAnswer');
Route::get('/answer/delete/{id}', 'AnswerController@destroy')->name('deleteAnswer');

Route::get('/analysis', 'AnalysisController@index');
Route::get('/analysis/process', 'AnalysisController@analysis')->name('analysis');
Route::get('/analysis/tes', 'AnalysisController@analysis');

Route::get('/process', 'ProcessController@index');
Route::get('/process/testing', 'ProcessController@testing');

Route::get('/training', 'DataTrainingController@index');
Route::post('/training/import-csv', 'DataTrainingController@import_csv')->name('importCSV');
