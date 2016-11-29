<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $ndb_id
 * @property integer $category_id
 * @property integer $diet_type_id
 * @property string $slug
 * @property string $title_en
 * @property string $title_ru
 * @property string $image
 * @property string $description_short
 * @property string $description_full
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ndb_id', 'category_id', 'diet_type_id'], 'integer'],
            [['description_short', 'description_full'], 'string'],
            [['slug', 'title_en', 'title_ru', 'image'], 'string', 'max' => 255],
            [['nutrients'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ndb_id' => 'Ndb ID',
            'category_id' => 'Category ID',
            'diet_type_id' => 'Diet Type ID',
            'slug' => 'Slug',
            'title_en' => 'Title En',
            'title_ru' => 'Title Ru',
            'image' => 'Image',
            'description_short' => 'Description Short',
            'description_full' => 'Description Full',
        ];
    }

    public function getNutrients() {
        return $this->hasMany(ProductNutrient::className(), ['product_id'=>'id']);
    }

    /*public function getNutrients() {
        return $this->hasMany(TestNutrient::className(), ['id'=>'nutrient_id'])
            ->viaTable('product_nutrient', ['product_id'=>'id']);
    }*/
}
