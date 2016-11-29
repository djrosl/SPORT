<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_nutrient`.
 */
class m161116_091753_create_product_nutrient_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_nutrient', [
            'id' => $this->primaryKey(),
            'product_slug' => $this->string(),
            'nutrient_slug' => $this->string(),
            'value' => $this->integer(),
            'scale' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_nutrient');
    }
}
