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

        //var_dump($data[0]);
        //echo $file;
        return 1;
    }

    public function actionUsda($file = ''){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file);

        foreach($data as $product){
            $desc = str_replace(',', ', ', $product['Shrt_Desc']);
            //echo $desc;break;
            $model = Product::findOne(['title_en'=>$desc]);
            if(!$model){
                $replaced = 'NEW';
                $model = new Product();
                $model->title_en = $product['Shrt_Desc'];
                $model->save();
            } else {
                $replaced = 'REPLACED';
            }
            foreach($product as $key => $value){
                $nutrient = TestNutrient::findOne(['usda'=>$key]);
                if($nutrient){
                    $pn = ProductNutrient::findOne(['product_id'=>$model->id, 'nutrient_id'=>$nutrient->id]);
                    if(!$pn){
                        $pn = new ProductNutrient();
                        $pn->product_id = $model->id;
                        $pn->nutrient_id = $nutrient->id;
                    }
                    $val = (float)str_replace(',', '.', $value);
                    if($val || $pn->value){
                        $pn->value = $val > $pn->value ? $val : $pn->value;
                        $pn->save();
                    }
                }
            }


            echo $replaced.' '.$model->title_en.' DONE! ID: '.$model->id."\n";
        }

        //var_dump($data[0]);
        //echo $file;
        return 1;
    }

    public function actionTest(){
        echo 'test';

        return 1;
    }


}