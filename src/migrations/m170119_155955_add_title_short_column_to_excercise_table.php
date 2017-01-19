<?php

use yii\db\Migration;

/**
 * Handles adding title_short to table `excercise`.
 */
class m170119_155955_add_title_short_column_to_excercise_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('excercise', 'title_short', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('excercise', 'title_short');
    }
}
