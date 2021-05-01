<?php

namespace App\Rules;

use App\Model\Account;

class CreateAccountValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'name'            => 'required|int|minLength:6|maxLength:6|unique:'.Account::class,
	        'password'        => 'required|string|minLength:6|maxLength:12',
	        'password_repeat' => 'required|string|minLength:6|maxLength:12|sameAs:password',
	        'email'           => 'required|email|unique:'.Account::class
        ];
    }
}
