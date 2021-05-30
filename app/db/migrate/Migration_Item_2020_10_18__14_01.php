<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Item_2020_10_18__14_01
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 50)->index()->unique();
        $schema->int('cid', 11);
        $schema->smallint('defense', 3)->default(0);
        $schema->smallint('armor', 3)->default(0);
        $schema->smallint('attack', 3)->default(0);
        $schema->smallint('range', 3)->default(0);
        $schema->smallint('level', 3)->default(0);
        $schema->smallint('attack_speed', 3)->default(0);
        $schema->smallint('jutsu_damage', 3)->default(0);
        $schema->smallint('extra_def', 3)->default(0);
        $schema->smallint('protection_all', 3)->default(0);
        $schema->smallint('critical_chance', 3)->default(0);
        $schema->smallint('glove_fighting', 3)->default(0);
        $schema->smallint('sword_fighting', 3)->default(0);
        $schema->smallint('distance_fighting', 3)->default(0);
        $schema->smallint('health', 3)->default(0);
        $schema->smallint('chakra', 3)->default(0);
        $schema->smallint('health_regen', 3)->default(0);
        $schema->smallint('chakra_regen', 3)->default(0);
	    $schema->int('weight', 10)->default(0);
        $schema->varchar('type', 50);
        $schema->text('description')->null();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->drop();
    }
}
