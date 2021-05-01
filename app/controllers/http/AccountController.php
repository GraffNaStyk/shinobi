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
	}
	
	public function index()
	{
		return $this->render();
	}
	
	public function add()
	{
		return $this->render([
			'professions' => Character::getCharactersToSelect(),
			'towns'       => Town::getTownsToSelect()
		]);
	}

	public function login(Request $request)
	{
		if (! $this->validate($request->all(), LoginValidator::class)) {
			$this->sendError();
		}
		
		$acc = Account::select()->where('name', '=', $request->get('name'))->exist();
		
		if ($acc && $acc->password === sha1($request->get('password'))) {
			Auth::login($acc);
			$this->sendSuccess('Logged successfully', '/account/show');
		}
		
		$this->sendError('Wrong account or password');
	}
	
	public function store(Request $request)
	{
		if (! $this->validate($request->all(), CreateAccountValidator::class)) {
			$this->sendError();
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
			
			$this->sendError(null, 400, [], $errors);
		}

		try {
			$request->set('password', sha1($request->get('password')));
			Account::create($request->all());
			Player::create($fields);
			$this->sendSuccess('Account registered successful', '/account');
		} catch (\Exception $exception) {
			$this->sendError('There was an error in your request, please try in a minute');
		}
	}
	
	public function show()
	{
		return $this->render([
			'players' => Character::prepareCharactersToView(
				Player::select(['name', 'level', 'vocation', 'id'])
					->where('account_id', '=', Auth::id())->order(['level'], 'desc')->get()
			),
			'account' => Auth::account(),
		]);
	}
	
	public function logout()
	{
		Auth::logout();
		$this->redirect('/account');
	}
}
