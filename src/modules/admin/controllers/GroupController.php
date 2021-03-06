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
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class GroupController extends AdminController
{

	public function actionIndex($group = false){
		$search = \Yii::$app->request->post('search');

		$title = '';

		if($group){
		    $title = ProductGroup::findOne(['id'=>$group])->title;
        }

		$words = explode(' ', str_replace('&', ' ', $search));
		if($search){
		    $rows = (new \yii\db\Query())
				->select(['id','title_en','ndb_slug'])
				->from('product');
				//->where("MATCH(title_en) AGAINST ('+".trim(implode(' +', $words))."' IN BOOLEAN MODE)")
                //->orWhere(['like', 'title_en', $words[0]])

            foreach($words as $k => $word){
                if(!$k) {
                    $rows->where(['like', 'title_en', $word]);
                } else {
                    $rows->orWhere(['like', 'title_en', $word]);
                }
            }

                $groupModels = clone $rows;


                $rows->andWhere(['in_group'=>0]);

                $groupModels->andWhere(['in_group'=>1]);

                //var_dump($groupModels->all());die;

		    $exist = [];
            if($group){
                $exist = array_map(function($item){
                    return $item->product;
                }, ProductGroup::findOne(['id'=>$group])->products);
            }

			return $this->render('index', [
			    'exist'=>$exist,
                'models' => $rows->all(),
                'groupModels' => $groupModels->all(),
				'search'=>$search,
                'title'=>$title
			]);
		}

        if($group){
            $exist = array_map(function($item){
                return $item->product;
            }, ProductGroup::findOne(['id'=>$group])->products);

            $rows = [];

            return $this->render('index', [
                'exist'=>$exist,
                'models' => $rows,
                'search'=>$search,
                'title'=>$title
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

        if(!empty($post['groupExist'])){
		    $group = ProductGroup::findOne(['id'=>$post['groupExist']]);
		    /*foreach($group->products as $ptg){
		        $ptg->product->in_group = 0;
		        $ptg->product->save();
            }
            ProductToGroup::deleteAll(['group_id'=>$post['groupExist']]);*/
        } else {
            $group = new ProductGroup();
        }
		$group->title = $post['name'];
		$group->save();
		if(!empty($post['product'])){
            foreach($post['product'] as $product) {
                $model = new ProductToGroup();
                $model->group_id = $group->id;
                $model->product_id = $product;
                $model->save();

                $model->product->in_group = 1;
                $model->product->save();
            }
        }

		return $this->redirect(Url::to(['group/view','id'=>$group->id]));

	}

	public function actionView($id, $search = ''){

		if($id){
		    $post = \Yii::$app->request->post();
		    if($post){
		        if($post['action'] == 'move'){
                    $items = ProductToGroup::find()->where(['in', 'id', $post['selection']])->all();
		            foreach ($items as $item){
		                $item->group_id = $post['group'];
		                $item->save();
                    }
                }

                if($post['action'] == 'delete'){
		            ProductToGroup::deleteAll(['in', 'id', $post['selection']]);
                }

                if($post['action'] == 'related'){
                    $items = ProductToGroup::find()->where(['in', 'id', $post['selection']])->all();
                    $main = ProductToGroup::find()->joinWith('product')->where(['in', 'product_to_group.id', $post['selection']])
                        ->andWhere(['in', 'product.ndb_slug', ['cnf', 'aus']])->one();
                    if($main){
                    } else {
                        $main = $items[0];
                    }
                    $main->product->related_id = 0;
                    $main->product->save();
                    foreach ($items as $item){
                        if($item->product->id !== $main->product->id){
                            if($item->product->related){
                                foreach($item->product->related as $it){
                                    $it->related_id = $main->product->id;
                                    $it->save();
                                }
                            }
                            $item->product->related_id = $main->product->id;
                            $item->product->save();
                        }
                    }
                }
            }

			$group = ProductGroup::find()->where(['id'=>$id])->one();
			if(\Yii::$app->request->post('state')){
				$group->state = \Yii::$app->request->post('state');
				$group->save();
			}

			return $this->render('view', [
					'group'=>$group,
                    'search'=>$search
			]);
		}

		throw new NotFoundHttpException();
	}

    public function actionDelete($group){
        if($group){

            $grp = ProductGroup::findOne(['id'=>$group]);
            foreach($grp->products as $ptg){
                $ptg->product->in_group = 0;
                $ptg->product->save();
            }
            ProductToGroup::deleteAll(['group_id'=>$group]);

            $grp->delete();

            return $this->redirect(Url::to(['index']));
        }

        throw new NotFoundHttpException();
    }

    public function actionDeleteProductFromGroup($product, $group){
        $prod = ProductToGroup::findOne(['id'=>$product]);

        $prod->product->in_group = 0;
        $prod->product->save();
        $prod->delete();
        return $this->redirect(Url::to(['/admin/group/view', 'id'=>$group]));
    }

    public function actionSub($id){
        $group = ProductGroup::findOne(['id'=>$id]);

        if(\Yii::$app->request->post('name')){

                $model = new ProductGroup();
                $model->parent_id = $group->id;
                $model->title = \Yii::$app->request->post('name');
                $model->save();
            return $this->redirect(['/admin/group/view', 'id'=>$group->id]);
        }

        //var_dump(\Yii::$app->request->post('sub')['title']);die;

        return $this->render('sub', compact('group'));
    }

}