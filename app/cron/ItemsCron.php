<?php

namespace App\Cron;

use App\Workers\Items;

class ItemsCron
{
    public function __construct()
    {
		return (new Items());
    }
}
