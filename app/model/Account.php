<?php

namespace App\Model;

use App\Facades\Db\Model;

class Account extends Model
{
    public static string $table = 'accounts';
    
    public static function create(array $fields): void
    {
	    self::insert([
		    'name'     => $fields['name'],
		    'password' => $fields['password'],
		    'email'    => $fields['email']
	    ])->exec();
    }
}
