<?php

use yii\db\Migration;

/**
 * Handles adding parent_id to table `product_group`.
 */
class m170201_124757_add_parent_id_column_to_product_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product_group', 'parent_id', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product_group', 'parent_id');
    }
}
