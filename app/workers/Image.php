<?php

namespace App\Workers;

use App\Facades\Console\Console;
use App\Facades\Faker\Faker;
use App\Helpers\Storage;

class Image
{
	public static function get(?int $cid, string $name): bool
	{
		$insert = false;
		Storage::disk()->make('images');
		
		if ($cid === 0 || $cid === null) {
			return false;
		}

		if (empty(\App\Model\Image::select()->where('cid', '=', $cid)->exist())
			&& is_file(storage_path('private/cache/images/'.$cid.'.png'))
		) {
			$insert = true;
			$hash   = Faker::getUniqueStr(\App\Model\Image::class);
			
			copy(
				storage_path('private/cache/images/'.$cid.'.png'),
				storage_path('public/images/'.$hash.'.png')
			);

			\App\Model\Image::onDuplicate(['cid'])->create([
				'name'       => $name,
				'cid'        => $cid,
				'hash'       => $hash,
				'path'       => 'images/',
				'created_by' => 1,
				'ext'        => 'png',
			]);
		}
		
		return $insert;
	}
}
