<?php

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Db\Eloquent\Value;
use App\Model\Item;

class ItemsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(string $type='armors')
    {
    	$data = Item::as('i')
		    ->select([new Value('i.*'), 'img.path', 'img.ext', 'img.hash'])
		    ->join('images as img', 'img.cid', '=', 'i.cid')
		    ->where('i.type', '=', $type)
		    ->get();

    	$this->render([
    		'items'  => \App\Helpers\Item::parse($data),
		    'keys'   => array_keys(get_object_vars($data[0])),
		    'active' => $type
	    ]);
    }
}
