<?php

namespace App\Controllers;

use App\Facades\Log\Log;
use App\Facades\Http\Session;
use App\Model\Account;
use App\Model\User;

class Auth
{
	public static function id(): int
	{
		return (int) Session::get('account.id');
	}
	
	public static function name(): int
	{
		return (int) Session::get('account.name');
	}
	
	public static function account(): object
	{
		return (object) Session::get('account');
	}
	
	public static function isPageAdmin(): bool
	{
		return (bool) Session::get('account.page_admin');
	}
	
	public static function login(object $user): void
	{
		unset($user->password);
		Session::set('account', $user);
	}
	
	public static function refresh(): void
	{
		$account = Account::select()->where('id', '=', self::id())->exist();
		
		if ($account) {
			self::login($account);
		} else {
			Log::custom('error', ['msg' => 'Cannot reload account on id: ' . self::id()]);
		}
	}
	
	public static function logout(): void
	{
		Session::remove('account');
	}
}
