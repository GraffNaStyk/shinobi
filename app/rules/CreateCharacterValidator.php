<?php

namespace App\Rules;

use App\Helpers\Character;
use App\Helpers\Town;
use App\Model\Player;

class CreateCharacterValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'name'     => 'required|string|min_len:4|max_len:20|unique:'.Player::class.'|'.static::class.':checkName',
	        'vocation' => 'required|int|'.static::class.':characterExist',
	        'town_id'  => 'required|int|'.static::class.':townExist',
        ];
    }

    public static function characterExist($item): array
    {
    	if (! in_array($item, array_keys(Character::getAvailable()))) {
		    return ['msg' => 'Wrong value', 'field' => 'vocation'];
	    }

    	return [];
    }

	public static function townExist($item): array
	{
		if (! in_array($item, array_keys(Town::getAvailable()))) {
			return ['msg' => 'Wrong value', 'field' => 'town_id'];
		}
		
		return [];
	}
	
	public static function checkName($name): array
	{
		$prohibited = ['gm', 'cm', 'bn', 'adm', 'admin', 'kage', 'cn'];

		$check  = strtolower(substr($name, 0, 2));
		$check2 = strtolower(substr($name, 0, 4));
		$check3 = strtolower(substr($name, 0, 5));
		$check4 = strtolower(substr($name, 0, 3));
		
		if (in_array($check, $prohibited)
			|| in_array($check2, $prohibited)
			|| in_array($check3, $prohibited)
			|| in_array($check4, $prohibited)
		) {
			return ['msg' => 'Name cannot contains prohibited values', 'field' => 'name'];
		}

		return [];
	}
}
