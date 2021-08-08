<?php

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Model\News;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('Home');
    }

    public function index(): string
    {
        return $this->render([
        	'newses' => News::as('n')->select(['p.name', 'n.title', 'n.text', 'n.created_at'])
		        ->join('players as p', 'p.id', '=', 'n.created_by')
		        ->where('n.is_active', '=', 1)
		        ->order(['created_at'], 'desc')
		        ->get()
        ]);
    }
}
