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

// Route::get('/', 'WelcomeController@index');
//
Route::get('faker', 'InboxController@faker');

Route::get('/', 'HomeController@index');
Route::get('home/inbox', 'HomeController@getInbox');
Route::get('home/inbox/{phoneNumber}', 'HomeController@getConversation');
Route::post('home/send-message', 'HomeController@sendMessage');

Route::get('contacts', 'ContactController@index');
Route::post('contacts/store', 'ContactController@store');
Route::get('contacts/search/{kw?}', 'ContactController@search');
Route::get('contacts/send/{phoneNumber}', 'ContactController@prepare');
Route::post('contacts/destroy', 'ContactController@destroy');

Route::get('inbox', 'InboxController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
