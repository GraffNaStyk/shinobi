<?php

namespace App\Controllers;

use App\Facades\Http\Session;
use App\Facades\Log\Log;
use App\Model\Account;
use App\Model\User;

class Auth
{
    public static function id(): int
    {
        return (int) Session::get('user.id');
    }

    public static function user(): object
    {
        return (object) Session::get('user');
    }

    public static function login(object $user): void
    {
        unset($user->password);
        Session::set('user', $user);
    }
	
	public static function isPageAdmin(): bool
	{
		return (bool) Session::get('user.page_admin');
	}
	
	
	public static function refresh(): void
    {
        $user = Account::select()->where('id', '=', self::id())->exist();

        if ($user) {
            self::login($user);
        } else {
            Log::custom('error', ['msg' => 'Cannot reload user on id: '.self::id()]);
        }
    }

    public static function isLogged(): bool
    {
        return Session::has('user');
    }
}
