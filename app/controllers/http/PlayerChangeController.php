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
    
    public function changeEmail(): string
    {
    	return $this->render();
    }
	
	public function changePassword(): string
	{
		return $this->render();
	}

    public function storeEmail(Request $request): string
    {
		if (! $this->validate($request->all(), ChangeEmailValidator::class)) {
			return $this->sendError();
		}
	
	    Account::update(['email' => $request->get('email')])
			->where('id', '=', Auth::id())
			->exec();
		
		Auth::refresh();
		return $this->sendSuccess('Email changed', ['reload' => true]);
    }

	public function storePassword(Request $request): string
	{
		if (! $this->validate($request->all(), ChangePasswordValidator::class)) {
			return $this->sendError();
		}

		Account::update(['password' => sha1($request->get('password'))])
			->where('id', '=', Auth::id())
			->exec();
		
		Auth::refresh();
		return $this->sendSuccess('Password changed');
	}
}
