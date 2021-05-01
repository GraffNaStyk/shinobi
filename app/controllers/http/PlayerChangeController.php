<?php

namespace App\Controllers\Http;

use App\Controllers\Auth;
use App\Facades\Http\Request;
use App\Controllers\Controller;
use App\Helpers\Character;
use App\Helpers\Town;
use App\Model\Account;
use App\Model\Player;
use App\Rules\ChangeEmailValidator;
use App\Rules\ChangePasswordValidator;
use App\Rules\CreateCharacterValidator;

class PlayerChangeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function changeEmail()
    {
    	return $this->render();
    }
	
	public function changePassword()
	{
		return $this->render();
	}

    public function storeEmail(Request $request)
    {
		if (! $this->validate($request->all(), ChangeEmailValidator::class)) {
			$this->sendError();
		}
	
	    Account::update(['email' => $request->get('email')])
			->where('id', '=', Auth::id())
			->exec();
		
		Auth::refresh();
		$this->sendSuccess('Email changed');
    }

	public function storePassword(Request $request)
	{
		if (! $this->validate($request->all(), ChangePasswordValidator::class)) {
			$this->sendError();
		}

		Account::update(['password' => sha1($request->get('password'))])
			->where('id', '=', Auth::id())
			->exec();
		
		Auth::refresh();
		$this->sendSuccess('Password changed');
	}
}
