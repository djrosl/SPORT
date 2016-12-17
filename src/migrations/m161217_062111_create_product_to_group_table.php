<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_to_group`.
 */
class m161217_062111_create_product_to_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_to_group', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'group_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_to_group');
    }
}
