<?php

namespace App\Controllers\Middleware;

use App\Facades\Http\Request;
use App\Facades\Http\Response;
use App\Facades\Http\Router\Route;
use App\Facades\Http\Router\Router;
use App\Facades\Url\Url;
use App\Model\Account;

final class IsPageAdmin
{
    public function before(Request $request, Router $router)
    {
    	$account = Account::select(['page_admin'])->where('id', '=', \App\Controllers\Auth::id())->exist();

        if (! \App\Controllers\Auth::isPageAdmin() || (int) $account->page_admin === 0) {
        	if (Request::isAjax()) {
		        Response::json([], 401);
	        } else {
		        Route::goTo(Route::checkProtocol().'://'.getenv('HTTP_HOST').Url::base());
	        }
        }
    }
}
