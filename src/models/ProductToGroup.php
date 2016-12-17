<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_to_group".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $group_id
 */
class ProductToGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_to_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'group_id'], 'integer'],
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
            'group_id' => 'Group ID',
        ];
    }

    public function getProduct(){
    	return $this->hasOne(Product::className(), [
    			'id'=>'product_id'
			]);
		}
}
