<?php

use Illuminate\Support\Facades\Route;




//Gerneral Routes
Route::get('/', function () {
    return view('welcome');
});
Route::match(['get', 'post'], '/login', 'Auth\LoginController@login')->name('login')->middleware('guest');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


//Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::match(['get', 'post'], '/dashboard', 'AdminController@dashboard')->name('dashboard');

    //Member Module
    Route::match(['get', 'post'], '/addmember', 'AdminController@addmember')->name('addmember');
    Route::match(['get', 'post'], '/viewmember', 'AdminController@viewmember')->name('viewMember');
    Route::post('/updateinfo/{id}', 'AdminController@updateinfo')->name('updateinfo');
    Route::post('/changeStage', 'AdminController@changeStage')->name('changeStage');

    //Sallary Module
    Route::match(['get', 'post'], '/paysallary', 'SallaryController@paysallary')->name('paysallary');
    Route::post('/paysallaryIn/{id}', 'SallaryController@paysallaryIn')->name('paysallaryIn');
    Route::post('/payallsallary', 'SallaryController@payallsalary')->name('payallsallary');

    Route::get('/sallaryRecord', 'SallaryController@sallaryRecord')->name('sallaryRecord');


    //Transection Module
    Route::match(['get', 'post'], '/addamount', 'transectionController@addamount')->name('addamount');
    Route::match(['get', 'post'], '/officeexpense', 'transectionController@officeexpense')->name('officeexpense');
    Route::match(['get', 'post'], '/foodexpense', 'transectionController@foodexpense')->name('foodexpense');

    //Profile
    Route::get('/profile', 'AdminController@profile')->name('profile');
    Route::match(['get', 'post'], '/editprofile', 'AdminController@editprofile')->name('editprofile');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'user'])->group(function () {
    Route::match(['get', 'post'], '/dashboard', 'UserController@dashboard')->name('dashboard');

    //User Salary Transection Module
    Route::get('/salary', 'SallaryController@salary')->name('salary');

    //User Transection Module
    Route::match(['get', 'post'], '/officeexpense', 'transectionController@userofficeexpense')->name('officeexpense');
    Route::match(['get', 'post'], '/foodexpense', 'transectionController@userfoodexpense')->name('foodexpense');

    //User profile
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::match(['get', 'post'], '/editprofile', 'UserController@editprofile')->name('editprofile');
});
