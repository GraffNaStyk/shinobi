<?php

namespace App\Controllers\Middleware;

use App\Facades\Http\Request;
use App\Facades\Http\Response;
use App\Facades\Http\Router\Route;
use App\Facades\Http\Router\Router;
use App\Facades\Http\Session;
use App\Model\Account;

final class IsLogged
{
    public function before(Request $request, Router $router)
    {
    	$account = Account::select(['id'])->where('id', '=', \App\Controllers\Auth::id())->exist();

        if (! Session::has('user') || ! $account) {
        	if (Request::isAjax()) {
		        Response::json([], 401);
	        } else {
		        Route::redirect('/account');
	        }
        }
    }
}
