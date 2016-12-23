<?php

use yii\db\Migration;

/**
 * Handles the creation of table `muscle_exercise_target`.
 */
class m161223_080809_create_muscle_exercise_target_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('muscle_exercise_target', [
            'id' => $this->primaryKey(),
            'muscle_id' => $this->integer(),
            'exercise_id' => $this->integer(),
        ]);

			$this->createTable('muscle_exercise_basic', [
					'id' => $this->primaryKey(),
					'muscle_id' => $this->integer(),
					'exercise_id' => $this->integer(),
			]);

			$this->createTable('muscle_exercise_synergy', [
					'id' => $this->primaryKey(),
					'muscle_id' => $this->integer(),
					'exercise_id' => $this->integer(),
			]);

			$this->createTable('muscle_exercise_stability', [
					'id' => $this->primaryKey(),
					'muscle_id' => $this->integer(),
					'exercise_id' => $this->integer(),
			]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('muscle_exercise_target');
    }
}
