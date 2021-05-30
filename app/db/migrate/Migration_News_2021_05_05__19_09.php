<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\News;


class Migration_News_2021_05_05__19_09
{
	public string $model = 'News';

	public function up(Schema $schema)
	{
		if (! $schema->hasColumn(News::$table, 'is_active')) {
			$schema->alter('is_active', 'tinyint', 1, false, 0, 'text');
		}
		$schema->run();
	}

	public function down(Schema $schema)
	{
	}
}
