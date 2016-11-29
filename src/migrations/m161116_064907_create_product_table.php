<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m161116_064907_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'ndb_id' => $this->integer(),
            'category_id' => $this->integer(),
            'diet_type_id' => $this->integer(),
            'slug' => $this->string(),
            'title_en' => $this->string(),
            'title_ru' => $this->string(),
            'image' => $this->string(),
            'description_short' => $this->text(),
            'description_full' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
