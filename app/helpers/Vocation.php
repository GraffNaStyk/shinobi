<?php

namespace App\Helpers;

class Vocation
{
	private static array $outfits = [
		1 => 108,
		2 => 113,
		3 => 119,
		4 => 125,
		5 => 131,
		6 => 137,
		7 => 143,
		8 => 149,
		9 => 155,
		10 => 161,
		11 => 167,
		12 => 173,
		13 => 179,
		14 => 185,
		15 => 191
	];
	
	public static function getOutfit(int $vocationId): int
	{
		return self::$outfits[$vocationId];
	}
}
