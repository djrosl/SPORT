<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_nutrient".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $nutrient_id
 * @property integer $value
 */
class ProductNutrient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_nutrient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'nutrient_id'], 'integer'],
            [['float'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'nutrient_id' => 'Nutrient ID',
            'value' => 'Value',
        ];
    }
}
