<?php

namespace App\Helpers;

class Item
{
	public static function parse($items): array
	{
		foreach ($items as $item) {
			$item->img = '/storage/public/'.$item->path.$item->hash.'.'.$item->ext;
			unset($item->description);
			unset($item->path);
			unset($item->ext);
			unset($item->hash);
		}
		
		return $items;
	}
}
