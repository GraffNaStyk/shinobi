<?php

namespace App\Helpers;

class Character
{
	private static array $characters = [
		1 => 'Naruto',
		2 => 'Sasuke',
		3 => 'Sakura',
		4 => 'Gaara',
		5 => 'Kankurou',
		6 => 'Temari',
		7 => 'Lee',
		8 => 'Neji',
		9 => 'Tenten',
		10 => 'Shikamaru',
		11 => 'Chouji',
		12 => 'Ino',
		13 => 'Kiba',
		14 => 'Shino',
		15 => 'Hinata',
	];
	
	
    public static function getAvailable(): array
    {
		return static::$characters;
    }
    
    public static function getCharactersToSelect(): array
    {
    	$return = [];

    	foreach (static::$characters as $key => $item) {
    		$return[] = [
    			'id'   => $key,
			    'name' => $item,
			    'src'  => '/storage/public/professions/'.mb_strtolower($item).'.png'
		    ];
	    }
    	
    	return $return;
    }
    
    public static function prepareCharactersToView(array $characters): array
    {
    	foreach ($characters as $character) {
    		$name = static::$characters[$character->vocation];
    		$character->experience = number_format($character->experience, 0, '.', '.');
    		$character->prof_name = $name;
    		$character->src       = '/storage/public/professions/'.mb_strtolower($name).'.png';
	    }

    	return $characters;
    }
}
