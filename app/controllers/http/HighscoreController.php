<?php

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Helpers\Character;
use App\Model\Player;

class HighscoreController extends Controller
{
	
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('Highscores');
    }

    public function index()
    {
    	return $this->render([
    		'players' => Character::prepareCharactersToView(
    			Player::select(['name', 'level', 'vocation', 'experience', 'maglevel'])
				    ->order(['level'], 'desc')
				    ->get()
		    )
	    ]);
    }
    
    public function filter(string $type)
    {
    }
}
