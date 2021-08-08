<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Account;

class Migration_Account_2021_04_30__22_25
{
	public string $model = 'Account';

	public function up(Schema $schema)
	{
		if (! $schema->hasColumn(Account::$table, 'page_admin')) {
			$schema->alter('page_admin', 'tinyint', 1, false, 0, 'type');
		}

		$schema->run();
	}

	public function down(Schema $schema)
	{
	}
}
