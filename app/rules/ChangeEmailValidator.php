<?php

namespace App\Rules;

use App\Model\Account;

class ChangeEmailValidator
{
    public function getRule(array $optional = []): array
    {
        return [
	        'email' => 'required|email|unique:'.Account::class
        ];
    }
}
