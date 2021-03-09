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
    //return view('welcome');
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/companies','CompanyController@index')->name('company.index');
Route::post('/company_add','CompanyController@insert')->name('company.insert');
Route::get('/company_edit/{id}','CompanyController@edit')->name('company.edit');
Route::post('/company_update','CompanyController@update')->name('company.update');
Route::get('/company_delete/{id}','CompanyController@delete')->name('company.delete');

Route::get('/employees','EmployeeController@index')->name('employee.index');

Route::post('/employee_add','EmployeeController@insert')->name('employee.insert');
Route::get('/employee_edit/{id}','EmployeeController@edit')->name('employee.edit');
Route::post('/employee_update','EmployeeController@update')->name('employee.update');
Route::get('/employee_delete/{id}','EmployeeController@delete')->name('employee.delete');
