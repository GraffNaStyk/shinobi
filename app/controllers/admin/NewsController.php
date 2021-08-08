<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Facades\Http\Request;
use App\Model\News;
use App\Model\Player;
use App\Rules\StoreNewsValidator;

class NewsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index(): string
	{
		return $this->render([
			'newses' => News::as('n')->select(['p.name', 'n.title', 'n.id', 'n.created_at', 'n.is_active'])
				->join('players as p', 'p.id', '=', 'n.created_by')
				->order(['created_at'], 'desc')
				->get()
		]);
	}
	
	public function add(): string
	{
		return $this->render([
			'players' => Player::select(['name as text', 'id as value'])->get()
		]);
	}
	
	public function store(Request $request): string
	{
		if (! $this->validate($request->all(), StoreNewsValidator::class)) {
			return $this->sendError();
		}
		
		News::insert($request->all())->exec();
		return $this->sendSuccess('News added!', [
			'to' => '/news'
		]);
	}
	
	public function edit(int $id): void
	{
	
	}
	
	public function active(Request $request): string
	{
		News::update(['is_active' => (int) $request->get('active') === 0 ? 1 : 0])
			->where('id', '=', $request->get('id'))
			->exec();

		return $this->sendSuccess('', ['reload' => true]);
	}
}
