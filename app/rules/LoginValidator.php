<?php

namespace App\Rules;

class LoginValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'name'     => 'required|int|minLength:6|maxLength:6',
	        'password' => 'required|string|maxLength:6|maxLength:12'
        ];
    }
}
