<?php

use yii\db\Migration;

/**
 * Handles adding direction to table `exercise`.
 */
class m170310_084923_add_direction_column_to_exercise_table extends Migration
{
    /**
     * @inheritdoc
     *
     */
    public function up()
    {
        $this->addColumn('exercise', 'direction', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('exercise', 'direction');
    }
}
