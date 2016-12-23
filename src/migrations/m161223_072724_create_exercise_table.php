<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exercise`.
 */
class m161223_072724_create_exercise_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('exercise', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'photo' => $this->string(),
            'video' => $this->string(),
            'equipment' => $this->string(),
            'plane' => $this->integer()->defaultValue(1),
            'type' => $this->integer()->defaultValue(1),
            'head_down' => $this->boolean()->defaultValue(0),
            'axis_power' => $this->boolean()->defaultValue(0),
            'trauma' => $this->boolean()->defaultValue(0),
            'ccal' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('exercise');
    }
}
