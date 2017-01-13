<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_group".
 *
 * @property integer $id
 * @property string $title
 */
class ProductGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'state'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getProducts(){
    	return $this->hasMany(ProductToGroup::className(),[
    			'group_id'=>'id'
			])->orderBy(['poducts.product.title_ru ASC'=>SORT_ASC]);
		}
}
