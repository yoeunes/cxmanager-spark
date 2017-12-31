<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::resource('/project', 'ProjectController');
// Route::get('/{team_slug}/projects', 'ProjectController@index');
Route::post('/issue', 'IssueController@store');
Route::get('/project/{project}/image', 'ProjectController@addimage');
Route::get('/project/create','ProjectController@create');
Route::post('/project', 'ProjectController@store');
Route::get('/project/{project}/edit', 'ProjectController@edit');
Route::patch('/project/{project}', 'ProjectController@update');
Route::delete('/projet/{project}', 'ProjectController@destroy');

Route::get('/issue', 'IssueController@index');
Route::get('/issue/show/{issue}', 'IssueController@show');
Route::get('/issue/create', 'IssueController@create');
Route::get('/issue/{issue}/edit', 'IssueController@edit');
Route::patch('/issue/{issue}', 'IssueController@update');
Route::post('/issue/{issue}/addphoto', 'IssueController@addphoto');
Route::delete('/issue/photo/{photo}', 'IssueController@deletephoto');
Route::delete('/issue/{issue}', 'IssueController@destroy');
Route::post('/comment/{issue}', 'IssuecommentController@store');
Route::get('/issue/resolved', 'IssueController@resolved');
Route::get('/issue/all', 'IssueController@all');

Route::get('/asset', 'AssetController@index');
Route::get('/asset/show/{asset}', 'AssetController@show');
Route::get('/asset/create', 'AssetController@create');
Route::post('/asset', 'AssetController@store');
Route::patch('/asset/{asset}', 'AssetController@update');
Route::delete('/asset/{asset}', 'AssetController@destroy');

Route::get('/checklist/{checklist}', 'ChecklistController@show');
Route::get('/checklist', 'ChecklistController@index');
Route::get('/checklist/create', 'ChecklistController@create');
Route::get('/checklist/{checklist}/edit', 'ChecklistController@edit');
Route::post('/checklist/{checklist}', 'ChecklistController@store');
Route::post('/checklist/{asset}/add', 'ChecklistController@add');
Route::patch('/checklist/{checklist}', 'ChecklistController@update');
Route::delete('/checklist/{checklist}', 'ChecklistController@destroy');

Route::get('/question/create', 'QuestionController@create');
Route::get('/question/{question}/edit', 'QuestionController@edit');
Route::patch('/question/{question}', 'QuestionController@update');
Route::post('/question', 'QuestionController@store');
Route::delete('/question/{question}', 'QuestionController@destroy');

Route::resource('functionaltest', 'FunctionaltestController');
Route::get('/functionaltest/{asset}/fill', 'FunctionaltestController@index');

Route::get('/report/checklist/{checklist}', 'ReportController@checklistreport');
Route::get('/report/checklistsuite/{asset}', 'ReportController@checklistsuitereport');
