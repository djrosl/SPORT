<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 7:29
 */

namespace app\modules\admin\controllers;


use app\models\Product;
use app\models\ProductGroup;
use app\models\ProductToGroup;
use nullref\admin\components\AdminController;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class GroupController extends AdminController
{

	public function actionIndex(){
		$search = \Yii::$app->request->post('search');

		if($search){
			$query = Product::find()->where(['like','title_en','% '.$search.' %', false])
			->orWhere(['like','title_en','% '.$search.', %', false])
			->orWhere(['like','title_en','%'.$search.', %', false])
			->orWhere(['like','title_en', $search.', %', false])
					->andWhere(['<','wordcount(title_en)',7])->all();

			return $this->render('index', [
					'models' => $query,
				'search'=>$search
			]);
		}

		return $this->render('index', [
				'groups'=>ProductGroup::find()->all(),
		]);
	}

	public function actionSaveGroup(){
		$post = \Yii::$app->request->post();
		if(!$post){
			return $this->render('index');
		}

		//var_dump($post['name']);die;

		$group = new ProductGroup();
		$group->title = $post['name'];
		$group->save();
		foreach($post['product'] as $product) {
			$model = new ProductToGroup();
			$model->group_id = $group->id;
			$model->product_id = $product;
			$model->save();
		}

		return $this->redirect(Url::to(['group/view','id'=>$group->id]));

	}

	public function actionView($id){
		if($id){
			$group = ProductGroup::find()->where(['id'=>$id])->one();
			if(\Yii::$app->request->post('state')){
				$group->state = \Yii::$app->request->post('state');
				$group->save();
			}

			return $this->render('view', [
					'group'=>$group
			]);
		}

		throw new NotFoundHttpException();
	}

}