<?php

use yii\db\Migration;

/**
 * Handles the creation of table `muscle`.
 */
class m161223_071724_create_muscle_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('muscle', [
            'id' => $this->primaryKey(),
            'group' => $this->string(),
            'title_ru' => $this->string(),
            'title_lat' => $this->string(),
            'type' => $this->integer()->defaultValue(1),
            'description' => $this->text(),
            'function' => $this->integer()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('muscle');
    }
}
