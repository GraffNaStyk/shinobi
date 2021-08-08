<?php

namespace App\Controllers\Http;

use App\Controllers\Auth;
use App\Facades\Http\Request;
use App\Controllers\Controller;
use App\Helpers\Character;
use App\Helpers\Town;
use App\Model\Player;
use App\Rules\CreateCharacterValidator;

class PlayerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function add(): string
    {
    	return $this->render([
		    'professions' => Character::getCharactersToSelect(),
		    'towns'       => Town::getTownsToSelect()
	    ]);
    }

    public function store(Request $request): string
    {
		if (! $this->validate($request->all(), CreateCharacterValidator::class)) {
			return $this->sendError();
		}
		
		$request->set('account_id', Auth::id());
		Player::create($request->all());
		return $this->sendSuccess('Character created', ['reload' => true]);
    }

    public function delete(Request $request): string
    {
		Player::delete()
			->where('account_id', '=', Auth::id())
			->where('id', '=', $request->get('id'))
			->exec();
		
		return $this->sendSuccess('Player delete');
    }
}
