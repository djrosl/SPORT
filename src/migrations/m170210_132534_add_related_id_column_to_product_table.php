<?php

use yii\db\Migration;

/**
 * Handles adding related_id to table `product`.
 */
class m170210_132534_add_related_id_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'related_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'related_id');
    }
}
