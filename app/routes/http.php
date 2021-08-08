<?php

use App\Facades\Http\Router\Router;
use App\Facades\Http\Router\Route;

Route::when('/admin', '/dash');

Route::namespace('App\Controllers\Http', function () {
	Route::get('/', 'Index@index');
	
	// --- Account routes ---
	Route::get('/account', 'Account@index')->middleware(['auth']);
	Route::get('/account/register', 'Account@add');
	Route::get('/account/logout', 'Account@logout');
	Route::post('/account/login', 'Account@login');
	Route::post('/account/store', 'Account@store');
	
	// --- Highscores filter routes ---
	Route::get('/highscores', 'Highscore@index');
	Route::get('/highscores/filter/{type}', 'Highscore@filter');
	
	// items routes
	Route::get('/items', 'Items@index');
	Route::get('/items/{type}', 'Items@index');
	
	Route::middleware('isLogged', function () {
		Route::get('/account/show', 'Account@show');
		Route::post('/player/store', 'Player@store');
		Route::get('/player/add', 'Player@add');
		Route::post('/player/delete', 'Player@delete');
		Route::get('/player/change/email', 'PlayerChange@changeEmail');
		Route::get('/player/change/password', 'PlayerChange@changePassword');
		Route::post('/player/store/email', 'PlayerChange@storeEmail');
		Route::post('/player/store/password', 'PlayerChange@storePassword');
	});
});

Route::namespace('App\Controllers\Admin', function () {
	Route::alias('/admin', function () {
		Route::middleware('IsPageAdmin', function () {
			Route::get('/dash', 'Dash@index');
			Route::crud('/news', 'News');
			Route::post('/news/active', 'News@active');
		});
	});
});

(new Router());
