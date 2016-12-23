<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "muscle".
 *
 * @property integer $id
 * @property string $group
 * @property string $title_ru
 * @property string $title_lat
 * @property integer $type
 * @property string $description
 * @property integer $function
 */
class Muscle extends \yii\db\ActiveRecord
{

	const TYPE_TOP = 1;
	const TYPE_DEEP = 2;

	const FUNCTION_PASTURAL = 1;
	const FUNCTION_PHASE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'muscle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'function'], 'integer'],
            [['description'], 'string'],
            [['group', 'title_ru', 'title_lat'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'title_ru' => 'Title Ru',
            'title_lat' => 'Title Lat',
            'type' => 'Type',
            'description' => 'Description',
            'function' => 'Function',
        ];
    }
}
