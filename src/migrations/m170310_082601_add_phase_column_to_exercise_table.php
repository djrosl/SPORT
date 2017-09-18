<?php

use yii\db\Migration;

/**
 * Handles adding phase to table `exercise`.
 */
class m170310_082601_add_phase_column_to_exercise_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('exercise', 'phase', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('exercise', 'phase');
    }
}
