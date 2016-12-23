<?php

use yii\db\Migration;

/**
 * Handles adding target to table `exercise`.
 */
class m161223_084256_add_target_column_to_exercise_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('exercise', 'target', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('exercise', 'target');
    }
}
