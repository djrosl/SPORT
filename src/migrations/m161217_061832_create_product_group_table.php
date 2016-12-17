<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_group`.
 */
class m161217_061832_create_product_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_group', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_group');
    }
}
