<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/users', 'UserController@tampil');

Route::post('/create_siswa', 'SiswaController@store');
Route::get('/siswa', 'SiswaController@tampil')->middleware('jwt.verify');
Route::put('/update_siswa', 'SiswaController@update')->middleware('jwt.verify');
Route::delete('/delete_siswa', 'SiswaController@destroy')->middleware('jwt.verify');

Route::post('/create_guru', 'GuruController@store');
Route::get('/guru', 'GuruController@tampil')->middleware('jwt.verify');
Route::put('/update_guru', 'GuruController@update')->middleware('jwt.verify');
Route::delete('/delete_guru', 'GuruController@destroy')->middleware('jwt.verify');

Route::post('/create_kelas', 'KelasController@store')->middleware('jwt.verify');
Route::get('/kelas', 'KelasController@tampil')->middleware('jwt.verify');
Route::put('/update_kelas', 'KelasController@update')->middleware('jwt.verify');
Route::delete('/delete_kelas', 'KelasController@destroy')->middleware('jwt.verify');

Route::post('/selesai','controlselesai@selesai');
Route::post('lihat','controlselesai@tampil');
