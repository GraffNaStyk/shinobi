<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class DashController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index(): string
	{
		return $this->render();
	}
}
