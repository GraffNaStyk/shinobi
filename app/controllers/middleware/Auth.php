<?php

namespace App\Controllers\Middleware;

use App\Facades\Http\Request;
use App\Facades\Http\Router\Route;
use App\Facades\Http\Router\Router;
use App\Facades\Http\Session;
use App\Model\Account;

final class Auth
{
    public function before(Request $request, Router $router)
    {
    	$account = Account::select(['id'])->where('id', '=', \App\Controllers\Auth::id())->exist();
    	
        if ((! Session::has('account')
	        || ! $account)
	        && ($router->getCurrentRoute()->getAction() !== 'index'
	        && $router->getCurrentRoute()->getController() === 'Account')
        ) {
	        Route::redirect('/account');
        } else if (Session::has('account')
	        && $account
	        && $router->getCurrentRoute()->getAction() !== 'show'
	        && $router->getCurrentRoute()->getController() === 'Account'
        ) {
	        Route::redirect('/account/show');
        }
    }
}
