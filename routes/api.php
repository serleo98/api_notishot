<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::prefix('v1')->group(function () {
    
    Route::namespace('User')->group(function () {
        Route::post('register', 'UserController@register')->name('register');
    });

    Route::namespace('Auth')->group(function () {
        Route::post('login', 'LoginController@login')->middleware('verified')->name('login');
        Route::post('logout', 'LoginController@logout')->name('logout');
    });


    Route::middleware(['auth:api', 'is.role:administrador'])->prefix('admin')->group(function () {
         Route::namespace('User')->group(function () {
             Route::resource('usuarios', 'UserController');
         });
     });

     Route::middleware(['auth:api', 'is.role:moderador'])->prefix('moderator')->group(function () {

     });

     Route::prefix('public')->group(function () {
        Route::namespace('Note')->group(function () {
            //asdasd
                Route::get('notas-portada','NoteController@showall')->name('public.portada');
                Route::get('noticia/{note}','NoteController@show')->name('public.noticia');
            });
        });

     Route::middleware(['auth:api', 'is.role:redactor'])->prefix('writer')->group(function () {
            Route::namespace('Note')->group(function () {
                Route::resource('notes', 'NoteController');
             });
     });
});

