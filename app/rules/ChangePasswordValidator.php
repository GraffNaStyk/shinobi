<?php

namespace App\Rules;

use App\Model\Account;

class ChangePasswordValidator
{
    public function getRule(array $optional = []): array
    {
        return [
	        'new_password' => 'required|string|minLength:6|maxLength:12',
	        'old_password' => 'required|string|minLength:6|maxLength:12|'.static::class.':isSamePassword',
        ];
    }
    
    public static function isSamePassword($password)
    {
        $password = Account::select(['password'])
	       ->where('password', '=', sha1($password))
	       ->exist();

        if (! $password) {
        	return ['msg' => 'Wrong old password', 'field' => 'old_password'];
        }
    }
}
