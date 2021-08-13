<?php

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Workers\Spells;

class SpellsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Spells $spells): string
    {
		return $this->render(['spells' => $spells->parse()]);
    }
}
