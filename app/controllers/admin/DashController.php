<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Facades\Http\View;

class DashController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		return View::render();
	}
}
