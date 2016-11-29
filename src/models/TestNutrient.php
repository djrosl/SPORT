<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_nutrient".
 *
 * @property integer $id
 * @property string $aus
 * @property string $usda
 * @property string $nuttab
 * @property string $cnf
 * @property string $unit
 * @property string $section
 * @property string $category
 * @property string $title_ru
 */
class TestNutrient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_nutrient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aus', 'usda', 'nuttab', 'cnf', 'unit', 'section', 'category', 'title_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aus' => 'Aus',
            'usda' => 'Usda',
            'nuttab' => 'Nuttab',
            'cnf' => 'Cnf',
            'unit' => 'Unit',
            'section' => 'Section',
            'category' => 'Category',
            'title_ru' => 'Title Ru',
        ];
    }
}
