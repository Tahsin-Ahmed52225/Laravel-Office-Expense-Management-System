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
    Route::post('/deletemember/{id}', 'AdminController@deletemember')->name('deletemember');




    //Sallary Module
    Route::match(['get', 'post'], '/paysallary', 'SallaryController@paysallary')->name('paysallary');
    Route::post('/paysallaryIn/{id}', 'SallaryController@paysallaryIn')->name('paysallaryIn');
    Route::post('/payallsallary', 'SallaryController@payallsalary')->name('payallsallary');
    Route::get('/sallaryRecord', 'SallaryController@sallaryRecord')->name('sallaryRecord');
    #update and delete route
    Route::post('/updateSallaryRecord/{id}', 'SallaryController@updateSallaryRecord')->name('updateSallaryRecord');
    Route::post('/deleteSallaryRecord/{id}', 'SallaryController@deleteSallaryRecord')->name('deleteSallaryRecord');




    //Advanced Module
    Route::match(['get', 'post'], '/advance', 'advanceController@advance')->name('advance');
    Route::post('/receive', 'advanceController@receive')->name('receive');
    #update and delete route
    Route::post('/deleteAdvanceRecord/{id}', 'advanceController@deleteAdvanceRecord')->name('deleteAdvanceRecord');
    Route::post('/updateAdvanceRecord/{id}', 'advanceController@updateAdvanceRecord')->name('updateAdvanceRecord');




    //Transection Module
    #add amount routes
    Route::match(['get', 'post'], '/addamount', 'transectionController@addamount')->name('addamount');
    Route::post('/updategaininfo/{id}', 'transectionController@updategaininfo')->name('updategaininfo');
    Route::post('/deletegaininfo/{id}', 'transectionController@deletegaininfo')->name('deletegaininfo');
    #office expense routes
    Route::match(['get', 'post'], '/officeexpense', 'transectionController@officeexpense')->name('officeexpense');
    Route::post('/updatefoodexpenseinfo/{id}', 'transectionController@updatefoodexpenseinfo')->name('updatefoodexpenseinfo');
    Route::post('/deletefoodexpenseinfo/{id}', 'transectionController@deletefoodexpenseinfo')->name('deletefoodexpenseinfo');
    #Food expense routes
    Route::match(['get', 'post'], '/foodexpense', 'transectionController@foodexpense')->name('foodexpense');
    #Transaction Record Route
    Route::match(['get', 'post'], '/transectionRecord/{type}', 'transectionController@record')->name('record');




    //Profile
    Route::get('/profile', 'AdminController@profile')->name('profile');
    Route::match(['get', 'post'], '/editprofile', 'AdminController@editprofile')->name('editprofile');




    //PDFgenerate
    Route::POST('salary/pdfdownload/yearly/', 'PdfController@Salary_PDF_Yearly')->name('SalaryPDFrecord');
    Route::POST('salary/pdfdownload/monthly/', 'PdfController@Salary_PDF_Monthly')->name('SalaryPDFrecordM');

    Route::POST('transaction/pdfdownload/yearly/{type}', 'PdfController@Transaction_PDF_Yearly')->name('TransactionPDFrecord');
    Route::POST('transaction/pdfdownload/monthly/{type}', 'PdfController@Transaction_PDF_Monthly')->name('TransactionPDFrecordM');





    //CSVgenerate
    Route::POST('salary/csvdownload/yearly/', 'CsvController@Salary_CSV_Yearly')->name('SalaryCSVrecord');
    Route::POST('salary/csvdownload/monthly/', 'CsvController@Salary_CSV_Monthly')->name('SalaryCSVrecordM');

    Route::POST('transaction/csvdownload/yearly/{type}', 'CsvController@Transaction_CSV_Yearly')->name('TransactionCSVrecord');
    Route::POST('transaction/csvdownload/monthly/{type}', 'CsvController@Transaction_CSV_Monthly')->name('TransactionCSVrecordM');
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
