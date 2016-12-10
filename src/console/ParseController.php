<?php

namespace app\console;

use app\models\Product;
use app\models\ProductNutrient;
use app\models\TestNutrient;
use Yii;
use yii\console\Controller;

class ParseController extends Controller {

    public function actionIndex($file = ''){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file);

        foreach($data as $product){
            $model = new Product();
            $model->title_en = $product['Food Name'];
            $model->save();

            foreach($product as $key => $value){
                $nutrient = TestNutrient::findOne(['aus'=>$key]);
                if($nutrient){
                    $pn = new ProductNutrient();
                    $pn->product_id = $model->id;
                    $pn->nutrient_id = $nutrient->id;
                    $pn->value = (float)str_replace(',', '.', $value);
                    $pn->save();
                }
            }
            echo $model->title_en.' DONE!'."\n";
        }

        return 1;
    }

    public function actionUsda($file = ''){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file);

        foreach($data as $product){
                $replaced = 'NEW';
                $model = new Product();
                $model->title_en = $product['Shrt_Desc'];
                $model->save();
            foreach($product as $key => $value){
                $nutrient = TestNutrient::findOne(['usda'=>$key]);
                if($nutrient){
                        $pn = new ProductNutrient();
                        $pn->product_id = $model->id;
                        $pn->nutrient_id = $nutrient->id;
                    $val = (float)str_replace(',', '.', $value);
                    if($val){
                        $pn->value = $val;
                        $pn->save();
                    }
                }
            }


            echo $replaced.' '.$model->title_en.' DONE! ID: '.$model->id."\n";
        }

        return 1;
    }

    public function actionNuttab($file = ''){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file);

        foreach($data as $product){
            $replaced = 'NEW';
            $model = Product::findOne(['ndb_id'=>$product['title_en']]);
            $nutrient = TestNutrient::findOne(['nuttab'=>$product['nuttab_slug']]);
            if($nutrient){
                $pn = new ProductNutrient();
                $pn->product_id = $model->id;
                $pn->nutrient_id = $nutrient->id;
                $val = (float)$product['value'];
                if($val){
                    $pn->value = $val;
                    $pn->save();
                }
            }
            echo $replaced.' '.$model->title_en.' DONE! ID: '.$model->id."\n";
        }

        return 1;
    }

    public function actionCnf($file = 'cnf.xls'){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file, [
            'getOnlySheet' => 'NUTRIENT AMOUNT'
        ]);

        foreach($data as $k => $product){

            //var_dump($product);die;

            $replaced = 'NEW';
            if(isset($model)){
                if($model->ndb_id == $product['ndb_id']){
                    $replaced = "SAME";
                } else {
                    $model = Product::findOne(['ndb_id'=>$product['ndb_id'], 'ndb_slug'=>'cnf']);
                }
            } else {
                $model = Product::findOne(['ndb_id'=>$product['ndb_id'], 'ndb_slug'=>'cnf']);
            }
            $nutrient = TestNutrient::findOne(['cnf'=>$product['slug']]);
            if($nutrient && $model){
                $val = (float)$product['value'];
                if($val){
                    $pn = new ProductNutrient();
                    $pn->product_id = $model->id;
                    $pn->nutrient_id = $nutrient->id;
                    $pn->value = $val;
                    $pn->save();
                }
            }
            echo $replaced.' '.$model->title_en.' DONE! ID: '.$model->id." KEY $k of 200000\n";
        }

        return 1;
    }

    public function actionTest(){
        echo 'test';

        return 1;
    }


}