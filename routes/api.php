<?php

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

Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('logout', 'Api\AuthController@logout');

    Route::resource('students', 'Api\StudentController', ['except' => ['create', 'edit']]);
    Route::resource('courses', 'Api\CourseController', ['except' => ['create', 'edit']]);
    Route::resource('semesters', 'Api\SemesterController', ['except' => ['create', 'edit']]);
    Route::resource('subjects', 'Api\SubjectController', ['except' => ['create', 'edit']]);
    Route::resource('marks', 'Api\MarksController', ['except' => ['create', 'edit']]);

    Route::post('getStudents', 'Api\StudentController@getStudents');
    Route::post('getSubjects', 'Api\SubjectController@getSubjects');
    Route::post('getMarks', 'Api\MarksController@getMarks');

    Route::get('student/{id}/{semester}/marks', 'Api\StudentController@getSemesterMarks');
});
