<?php

use yii\db\Migration;

/**
 * Handles adding ingroup to table `product`.
 */
class m170109_193954_add_ingroup_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->addColumn('product', 'in_group', $this->boolean()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'in_group');
    }
}
