<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/notes', 'NoteController@index')->name('notes.index');
Route::get('/notes/add', 'NoteController@add')->name('notes.add');
Route::get('/notes/{id}/edit', 'NoteController@edit')->name('notes.edit');

Route::post('/notes/add', 'NoteController@store')->name('notes.store');
Route::put('/notes/{id}', 'NoteController@update')->name('notes.update');
Route::delete('/notes/{id}', 'NoteController@destroy')->name('notes.destroy');

Route::get('/notes/{id}', 'NoteController@show')->name('notes.show');
