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

Route::auth();

Route::get('/', function () {
    return redirect('/home');
});
 
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(['middleware' => 'auth'], function () {
    // hack to avoid flash messages being cached by browser.
    // without using ajax, the flash message will display when user presses back button
    // TODO: find a more elegant solution
    Route::get('/flash', function() {
        echo json_encode(['message' => session()->pull('flash_message'), 'message_level' => session()->pull('flash_message_level')]);
    });

    // Route::get('/courses', ['as' => 'courses', 'uses' => 'CoursesController@index']);
    // Route::post('/courses', 'CoursesController@store');
    // Route::get('/courses/create', 'CoursesController@create');
    // Route::get('/courses/{course}', ['as' => 'course', 'uses' => 'CoursesController@show']);
    // Route::patch('/courses/{course}', 'CoursesController@update');
    Route::patch('/courses/{course}/lecturers', 'CoursesController@updateLecturers');
    Route::patch('/courses/{course}/students', 'CoursesController@updateStudents');
    Route::any('/courses/{course_id}/upload', 'CoursesController@upload');
    // Route::delete('/courses/{course}', 'CoursesController@destroy');

    Route::resource('courses', 'CoursesController', [
        'parameters' => 'singular',
        'except' => ['edit']
    ]);

    // Route::resource('courses', 'CoursesController', ['names' => [
    //     'show' => 'course'
    // ]]);
    Route::post('/lessons', 'LessonsController@store');
    Route::get('/lessons/create', 'LessonsController@create');
    Route::get('/lessons/{lesson}', ['as' => 'lesson', 'uses' => 'LessonsController@show']);
    Route::patch('/lessons/{lesson}', 'LessonsController@update');
    Route::patch('/lessons/{lesson}/publish', 'LessonsController@setPublishedStatus');
    Route::delete('/lessons/{lesson}', 'LessonsController@destroy');

    Route::post('/lessons/{lesson}/files', 'LessonFilesController@store');
    // Route::resource('files', 'LessonFilesController', ['except' => [
    //     'index', 'create', 'show', 'store'
    // ]]);

    Route::patch('/files/{lesson_file}', 'LessonFilesController@update');
    Route::delete('/files/{lesson_file}', 'LessonFilesController@destroy');
    Route::get('/files/{lesson_file}/edit', 'LessonFilesController@edit');

    // Medium editor image upload path
    Route::any('/lessons/{lesson_id}/upload', 'LessonsController@upload');
    Route::any('/lessons/{lesson_id}/removeUpload', 'LessonsController@removeUpload');

    Route::patch('users/{user}/setadmin', 'UserController@setAdminStatus');
    Route::any('users/{user_id}/upload', 'UserController@upload');
    
    Route::resource('users', 'UserController', [
        'parameters' => 'singular',
        'except' => ['edit']
    ]);
    
    Route::resource('teams', 'TeamController', [
        'parameters' => 'singular',
        'except' => ['edit']
    ]);
    
    Route::any('teams/{team_id}/player', 'PlayersController@player');
    
    Route::resource('players', 'PlayersController', [
        'parameters' => 'singular',
        'except' => ['edit']
    ]);
    Route::any('players/update/{id}', 'PlayersController@update');
    
    Route::resource('match', 'MatchesController', [
        'parameters' => 'singular',
        'except' => ['edit']
    ]);
});