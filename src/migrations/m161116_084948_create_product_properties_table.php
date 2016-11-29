<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_properties`.
 */
class m161116_084948_create_product_properties_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_properties', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'good_properties' => $this->text(),
            'bad_properties' => $this->text(),
            'taste' => $this->string(),
            'color' => $this->string(),
            'ph' => $this->string(),
            'maturation' => $this->string(),
            'starch' => $this->boolean(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_properties');
    }
}
