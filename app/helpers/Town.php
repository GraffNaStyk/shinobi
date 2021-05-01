<?php

namespace App\Helpers;

class Town
{
	private static array $towns = [
		1 => 'Konohagakure',
		2 => 'Sunagakure',
		3 => 'Iwagakure'
	];
	
	private static array $pos = [
		1 => ['x' => 1000, 'y' => 1000, 'z' => 7],
		2 => ['x' => 1000, 'y' => 1000, 'z' => 7],
		3 => ['x' => 1000, 'y' => 1000, 'z' => 7]
	];
	
    public static function getAvailable(): array
    {
		return static::$towns;
    }
    
    public static function getTownPos(int $id): array
    {
    	return static::$pos[$id];
    }
    
    public static function getTownsToSelect(): array
    {
    	$return = [];
    	
    	foreach (static::$towns as $key => $item) {
    		$return[] = [
    			'value' => $key,
			    'text' => $item
		    ];
	    }
    	
    	return $return;
    }
}
