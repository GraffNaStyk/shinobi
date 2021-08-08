<?php

namespace App\Controllers\Http;

use App\Controllers\Auth;
use App\Facades\Http\Request;
use App\Controllers\Controller;
use App\Facades\Validator\Validator;
use App\Helpers\Character;
use App\Helpers\Town;
use App\Model\Account;
use App\Model\Player;
use App\Rules\CreateAccountValidator;
use App\Rules\CreateCharacterValidator;
use App\Rules\LoginValidator;

class AccountController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Account');
	}
	
	public function index(): string
	{
		return $this->render();
	}
	
	public function add():string
	{
		return $this->render([
			'professions' => Character::getCharactersToSelect(),
			'towns'       => Town::getTownsToSelect()
		]);
	}

	public function login(Request $request): string
	{
		if (! $this->validate($request->all(), LoginValidator::class)) {
			return $this->sendError();
		}
		
		$acc = Account::select()->where('name', '=', $request->get('name'))->exist();
		
		if ($acc && $acc->password === sha1($request->get('password'))) {
			Auth::login($acc);
			return $this->sendSuccess('Logged successfully', [
				'to' => '/account/show'
			]);
		}
		
		return $this->sendError('Wrong account or password');
	}
	
	public function store(Request $request): string
	{
		if (! $this->validate($request->all(), CreateAccountValidator::class)) {
			return $this->sendError();
		}
		
		$fields = $request->all();
		$fields['name'] = $fields['nickname'];

		if (! $this->validate($fields, CreateCharacterValidator::class)) {
			$errors = [];
			
			foreach (Validator::getErrors() as $item) {
				if ($item['field'] === 'name') {
					$item['field'] = 'nickname';
				}
				$errors[] = $item;
			}
			
			return $this->sendError('Field name and nickname must be same');
		}

		try {
			$request->set('password', sha1($request->get('password')));
			Account::create($request->all());
			Player::create($fields);
			return $this->sendSuccess('Account registered successful', [
				'to' => '/account'
			]);
		} catch (\Exception $exception) {
			return $this->sendError('There was an error in your request, please try in a minute');
		}
	}
	
	public function show(): string
	{
		return $this->render([
			'players' => Character::prepareCharactersToView(
				Player::select(['name', 'level', 'vocation', 'id'])
					->where('account_id', '=', Auth::id())->order(['level'], 'desc')->get()
			),
			'account' => Auth::user(),
		]);
	}
	
	public function logout(): void
	{
		Auth::logout();
		$this->redirect('/account');
	}
}
