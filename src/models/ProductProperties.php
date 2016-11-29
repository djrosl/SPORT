<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_properties".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $good_properties
 * @property string $bad_properties
 * @property string $taste
 * @property string $color
 * @property string $ph
 * @property string $maturation
 * @property integer $starch
 */
class ProductProperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'starch'], 'integer'],
            [['good_properties', 'bad_properties'], 'string'],
            [['taste', 'color', 'ph', 'maturation'], 'string', 'max' => 255],
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
            'good_properties' => 'Good Properties',
            'bad_properties' => 'Bad Properties',
            'taste' => 'Taste',
            'color' => 'Color',
            'ph' => 'Ph',
            'maturation' => 'Maturation',
            'starch' => 'Starch',
        ];
    }
}
