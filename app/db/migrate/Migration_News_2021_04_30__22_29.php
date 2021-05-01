<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_News_2021_04_30__22_29
{
	public string $model = 'News';

	public function up(Schema $schema)
	{
		$schema->int('id', 11)->primary()->unsigned();
		$schema->varchar('title', 100);
		$schema->text('text');
		$schema->timestamp('created_at')->default('CURRENT_TIMESTAMP');
		$schema->int('created_by', 11);
		$schema->run();
	}

	public function down(Schema $schema)
	{
		$schema->clear();
	}
}
