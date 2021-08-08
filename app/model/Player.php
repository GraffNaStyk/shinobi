<?php

namespace App\Model;

use App\Facades\Db\Model;
use App\Helpers\Town;

class Player extends Model
{
    public static string $table = 'players';
    
    public static function create(array $fields)
    {
    	$pos = Town::getTownPos($fields['town_id']);
    	
	    self::insert([
		    'name'       => ucfirst($fields['name']),
		    'vocation'   => $fields['vocation'],
		    'town_id'    => $fields['town_id'],
		    'posx'       => $pos['x'],
		    'posy'       => $pos['y'],
		    'posz'       => $pos['z'],
 		    'conditions' => 0,
		    'account_id' => self::lastId() ?: $fields['account_id']
	    ])->exec();
    }
}
