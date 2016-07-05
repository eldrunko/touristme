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

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/register','Auth\AuthController@getRegister');
Route::post('auth/register','Auth\AuthController@postRegister');

Route::post('api/guide/create',[//trasforma l'utente auth in guida
	"middleware"=>"auth:api",
	"uses"=>"GuideController@addguide"
	]);



Route::post('api/place/dump',[//elenca i posti disponibili
	"middleware"=>"auth:api",
	"uses"=>"PlaceController@dump",
	]);

//place_id
Route::post('api/service/create',[//crea un servizio per la guida autenticata
	"middleware"=>"auth:api",
	"uses"=>"PlaceController@addservice",
	]);

Route::post('api/service/reserve',[//creates a reservation
	'middleware'=>'auth:api',
	"uses"=>'PlaceController@reserve',
	]);

Route::post('api/service/review',[//reviews a journey
	'middleware'=>'auth:api',
	'uses'=>'PlaceController@review',
	]);
Route::get('route/vietata',[
	"uses"=>'GuideController@fire'
	]);//prova per la relation

Route::any('api/place/search',[//trova le guide di un certo posto
	"middleware"=>"auth:api",
	"uses"=>"PlaceController@findguides"
	]);

Route::get('api/user/{id}',[//il profilo
	"uses"=>"UserController@showuser",
	]);

Route::get('api/user/prenota/{id}',[
	"uses"=>"UserController@showform
	"]);

Route::post('prenota',[
	"uses"=>"UserController@reserve", 
						//"middleware"=>"auth",
						]);//meglio via auth:api. per ora questo?