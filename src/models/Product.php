<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
            [['category_id', 'diet_type_id', 'related_id'], 'integer'],
            [['ndb_id', 'ndb_slug', 'description_short', 'description_full'], 'string'],
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

    public function getSame(){
        $words = explode(',', strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', ' ', $this->title_en))));
        $rows = (new \yii\db\Query())
            ->select(['id'])
            ->from('product')
            ->where("MATCH(title_en) AGAINST ('+".trim(implode(' +', $words))."' IN BOOLEAN MODE)")
						->andWhere(['!=','ndb_slug',$this->ndb_slug])
            ->all();

        /*$arr = array_filter($rows, function($item) use ($words){
            return count(explode(',', strtolower(str_replace(' ', '', $item['title_en'])))) == count($words);
        });
        var_dump($arr);die;*/


        return $rows;
    }

	/*public function getSameOne(){
		$words = explode(',', strtolower(str_replace(' ', '', $this->title_en)));
		$words2 = array_unique(explode(' ', strtolower(str_replace(',', '', $this->title_en))));
		$newarr = array_unique(array_merge($words, $words2));
		$words = array_filter($newarr, function($value) { return $value !== ''; });

		$rows = (new \yii\db\Query())
				->select(['id'])
				->from('product')
				->where("MATCH(title_en) AGAINST ('+".trim(implode(' +', $words))."' IN BOOLEAN MODE)");

		for($i=1;$i<count($words)-1;$i++){
			$arr = $words;
			unset($arr[$i]);

			$rows->orWhere("MATCH(title_en) AGAINST ('".trim(implode(' +', $arr))."' IN BOOLEAN MODE)");
		}

		$rows->andWhere(['!=','ndb_slug',$this->ndb_slug])
				->andWhere(['<=', 'wordcount(title_en)', count($words)+1]);


		return array_slice($rows->all(),0,20);
	}*/
	public function getSameOne(){
		$words = explode(',', strtolower(str_replace(' ', '', str_replace('&', ' ', $this->title_en))));
		$words2 = array_unique(explode(' ', strtolower(str_replace(',', '', $this->title_en))));
		$newarr = array_unique(array_merge($words, $words2));
		$words = array_filter($newarr, function($value) { return $value !== ''; });

		$rows = (new \yii\db\Query())
				->select(['id'])
				->from('product');

		$rows->where(['like', 'title_en', '%'.$words[0].'%', false]);
		if(!empty($words[1])){
			$rows->andWhere(['like', 'title_en', '%'.$words[1].'%', false]);
		}

		$rows->andWhere(['!=','ndb_slug',$this->ndb_slug])
				->andWhere(['<=', 'wordcount(title_en)', count($words)+1]);


		return array_slice($rows->all(),0,20);
	}

	public function getGroup(){
        return $this->hasOne(ProductToGroup::className(),[
            'group_id'=>'id'
        ]);
    }

    public function getRelated(){
	    return $this->hasMany(Product::className(), [
            'related_id'=>'id'
        ]);
    }
}


/*
 *
SELECT * FROM product
WHERE MATCH(title_en) AGAINST ('+celery +raw' IN BOOLEAN MODE);
 * */