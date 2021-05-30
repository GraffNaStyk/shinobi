<?php

namespace App\Rules;

use App\Model\Account;

class CreateAccountValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'name'            => 'required|int|min_len:6|max_len:6|unique:'.Account::class,
	        'password'        => 'required|string|min_len:6|max_len:12',
	        'password_repeat' => 'required|string|min_len:6|max_len:12|same_as:password',
	        'email'           => 'required|email|unique:'.Account::class
        ];
    }
}
