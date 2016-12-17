<?php

use yii\db\Migration;

class m161217_073702_add_state_field_to_product_group_table extends Migration
{
    public function up()
    {
				$this->addColumn('product_group', 'state', 'string');
    }

    public function down()
    {
        echo "m161217_073702_add_state_field_to_product_group_table cannot be reverted.\n";

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
