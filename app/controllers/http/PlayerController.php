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
    
    public function add()
    {
    	return $this->render([
		    'professions' => Character::getCharactersToSelect(),
		    'towns'       => Town::getTownsToSelect()
	    ]);
    }

    public function store(Request $request)
    {
		if (! $this->validate($request->all(), CreateCharacterValidator::class)) {
			$this->sendError();
		}
		
		$request->set('account_id', Auth::id());
		Player::create($request->all());
		$this->sendSuccess('Character created');
    }

    public function delete(Request $request)
    {
		Player::delete()
			->where('account_id', '=', Auth::id())
			->where('id', '=', $request->get('id'))
			->exec();
		
		$this->sendSuccess('Player delete');
    }
}
