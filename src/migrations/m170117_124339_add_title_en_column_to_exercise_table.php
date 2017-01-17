<?php

use yii\db\Migration;

/**
 * Handles adding title_en to table `exercise`.
 */
class m170117_124339_add_title_en_column_to_exercise_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('exercise', 'title_en', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('exercise', 'title_en');
    }
}
