<?php

use yii\db\Migration;

class m161227_070456_add_capacity_field_to_exercise_table extends Migration
{
    public function up()
    {
			$this->addColumn('exercise', 'capacity', $this->integer());
    }

    public function down()
    {
        echo "m161227_070456_add_capacity_field_to_exercise_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
