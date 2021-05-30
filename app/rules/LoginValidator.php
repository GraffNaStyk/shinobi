<?php

namespace App\Rules;

class LoginValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'name'     => 'required|int|min_len:6|max_len:6',
	        'password' => 'required|string|min_len:6|max_len:12'
        ];
    }
}
