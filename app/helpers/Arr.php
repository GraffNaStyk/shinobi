<?php


namespace App\Helpers;


use App\Facades\Property\Get;
use App\Facades\Property\Has;
use App\Facades\Property\Set;
use App\Facades\Validator\Type;

class Arr
{
	private static array $arr;
	
	public static function init(array $array): Arr
	{
		static::$arr = $array;
		
		return new static();
	}
	
	public static function each(array $array, callable $function): array
	{
		foreach ($array as $key => $item) {
			$array[$key] = $function($key, $item);
		}

		return $array;
	}

	public static function has(array $array, string $offset): bool
	{
		return Has::check($array, $offset);
	}
	
	public static function get(array $array, string $offset)
	{
		return Get::check($array, $offset);
	}
	
	public static function set($item, $data)
	{
		return array_merge(static::$arr, Set::set(static::$arr, Type::get($data), $item));
	}
	
	public static function all()
	{
		return static::$arr;
	}
}
