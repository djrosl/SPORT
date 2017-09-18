<?php

namespace app\console;

use app\components\ArrayHelper;
use app\models\Product;
use app\models\ProductNutrient;
use app\models\TestNutrient;
use Yii;
use yii\console\Controller;
use Stichoza\GoogleTranslate\TranslateClient;

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

    public function actionUsdaFat(){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/parser_files/usda.csv');

        foreach($data as $product){
            $replaced = 'UPD';
            $model = Product::findOne(['title_en'=>$product['Shrt_Desc']]);
            if($model){
                    $pn = new ProductNutrient();
                    $pn->product_id = $model->id;
                    $pn->nutrient_id = 30;
                    $val = (float)str_replace(',', '.', $product['Lipid_Tot_(g)']);
                    if($val){
                        $pn->value = $val;
                        $pn->save();
                    }
                echo $replaced.' '.$model->title_en.' DONE! FAT: '.$val."\n";
            }
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

    public function actionNuttabEnergy(){
        $data = array_filter(\moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/nuttab.csv'), function($item){
            return $item['Nutrient ID'] == 'ENERGY-04DF';
        });
        foreach($data as $k => $product){
            $model = Product::findOne(['ndb_id'=>$product['Food ID'], 'ndb_slug'=>'nuttab']);
            $nut = 1;
            $pnut = new ProductNutrient();
            $pnut->product_id = $model->id;
            $pnut->nutrient_id = $nut;
            $pnut->value = (int)$product['Value'] / 4.184;

            echo $pnut->value ."\n";
            $pnut->save();
        }
    }

    public function actionCnf($file = 'cnf.xls'){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/'.$file, [
            'getOnlySheet' => 'NUTRIENT AMOUNT'
        ]);
        ini_set('max_execution_time', -1);

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

    public function actionTranslate(){
        $data = ArrayHelper::map(\moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/parser_files/translations.csv'), 'a', 'b');

        $models = Product::find()->all();

        foreach($models as $k => $model){
            $arr = explode(',', strtolower(str_replace(', ', ',', $model->title_en)));
            $tr = new TranslateClient('en', 'ru');
            $translated = array_map(function($word) use ($tr, $data){
                if(!empty($data[$word])){
                   return $data[$word];
                }
                return $tr->translate($word);
            }, $arr);
            $model->title_ru = implode(', ', $translated);
            $model->save();
            echo $model->title_ru .' <=> '.$model->title_en."\n";
            if($k%100 === 0){
                sleep(5);
                echo 'sleeping...'."\n";
            }
        }

        return 1;

    }

    protected function findSlug($id){
        $slugs = ["203"=>"PROT",
            "204"=>"FAT",
            "205"=>"CARB",
            "207"=>"ASH",
            "208"=>"KCAL",
            "810"=>"STAR",
            "210"=>"SUCR",
            "211"=>"GLUC",
            "212"=>"FRUC",
            "213"=>"LACT",
            "214"=>"MALT",
            "221"=>"ALCO",
            "245"=>"OXAL",
            "255"=>"H2O",
            "260"=>"MANN",
            "261"=>"SORB",
            "262"=>"CAFF",
            "263"=>"THBR",
            "268"=>"KJ",
            "269"=>"TSUG",
            "287"=>"GAL",
            "291"=>"TDF",
            "301"=>"CA",
            "303"=>"FE",
            "304"=>"MG",
            "305"=>"P",
            "306"=>"K",
            "307"=>"NA",
            "309"=>"ZN",
            "312"=>"CU",
            "315"=>"MN",
            "317"=>"SE",
            "319"=>"RT-�G",
            "814"=>"RAE",
            "321"=>"BC-�G",
            "834"=>"AC-�G",
            "323"=>"ATMG",
            "324"=>"D-IU",
            "876"=>"D2-�G",
            "339"=>"D3+D2-�G",
            "835"=>"CRYPX",
            "836"=>"LYCPN",
            "837"=>"LUT+ZEA",
            "811"=>"BTMG",
            "812"=>"GTMG",
            "813"=>"DTMG",
            "401"=>"VITC",
            "404"=>"THIA",
            "405"=>"RIBO",
            "406"=>"N-MG",
            "409"=>"N-NE",
            "410"=>"PANT",
            "415"=>"B6",
            "416"=>"BIOT",
            "417"=>"FOLA",
            "418"=>"B12",
            "862"=>"CHOLN",
            "430"=>"VITK",
            "431"=>"FOAC",
            "806"=>"FOLN",
            "815"=>"DFE",
            "863"=>"BETN",
            "501"=>"TRP",
            "502"=>"THR",
            "503"=>"ISO",
            "504"=>"LEU",
            "505"=>"LYS",
            "506"=>"MET",
            "507"=>"CYS",
            "508"=>"PHE",
            "509"=>"TYR",
            "510"=>"VAL",
            "511"=>"ARG",
            "512"=>"HIS",
            "513"=>"ALA",
            "514"=>"ASP",
            "515"=>"GLU",
            "516"=>"GLY",
            "517"=>"PRO",
            "518"=>"SER",
            "828"=>"HYP",
            "550"=>"ASPA",
            "875"=>"ATMG-A",
            "874"=>"B12-A",
            "601"=>"CHOL",
            "605"=>"TRFA",
            "606"=>"TSAT",
            "607"=>"4:0",
            "608"=>"6:0",
            "609"=>"8:0",
            "610"=>"10:0",
            "611"=>"12:0",
            "612"=>"14:0",
            "613"=>"16:0",
            "614"=>"18:0",
            "615"=>"20:0",
            "617"=>"18:1undiff",
            "618"=>"18:2undiff",
            "619"=>"18:3undiff",
            "620"=>"20:4undiff",
            "621"=>"22:6n-3DHA",
            "624"=>"22:0",
            "625"=>"14:1",
            "626"=>"16:1undiff",
            "627"=>"18:4",
            "628"=>"20:1",
            "629"=>"20:5n-3EPA",
            "630"=>"22:1undiff",
            "631"=>"22:5n-3DPA",
            "636"=>"TPST",
            "638"=>"STIG",
            "866"=>"CAMSTR",
            "816"=>"SITSTR",
            "645"=>"MUFA",
            "646"=>"PUFA",
            "652"=>"15:0",
            "653"=>"17:0",
            "654"=>"24:0",
            "817"=>"16:1t",
            "818"=>"18:1t",
            "852"=>"22:1t",
            "819"=>"18:2i",
            "853"=>"18:2t,t",
            "838"=>"18:2cla",
            "820"=>"24:1c",
            "823"=>"20:2cc",
            "821"=>"16:1c",
            "824"=>"18:1c",
            "825"=>"18:2ccn-6",
            "840"=>"22:1c",
            "832"=>"18:3cccn-6",
            "826"=>"17:1",
            "827"=>"20:3undiff",
            "829"=>"TRMO",
            "859"=>"TRPO",
            "830"=>"13:0",
            "833"=>"15:1",
            "802"=>"TMOS",
            "803"=>"TDIS",
            "831"=>"18:3cccn-3",
            "861"=>"20:3n-3",
            "854"=>"20:3n-6",
            "855"=>"20:4n-6",
            "841"=>"18:3i",
            "843"=>"21:5",
            "845"=>"22:4n-6",
            "846"=>"24:1undiff",
            "847"=>"12:1",
            "848"=>"22:3",
            "849"=>"22:2",
            "868"=>"TOmega n-3",
            "869"=>"TOmega n-6",];
        return $slugs[$id];
    }

    public function actionAusCarbon(){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/parser_files/aus.csv');
        ini_set('max_execution_time', -1);

        foreach($data as $product){
            $replaced = 'UPD';
            $model = Product::findOne(['ndb_slug'=>'aus','title_en'=>$product['Food Name']]);
            if($model){
                $pn = new ProductNutrient();
                $pn->product_id = $model->id;
                $pn->nutrient_id = 10;
                $val = (float)str_replace(',', '.', $product['Available carbohydrates, with sugar alcohols (g)']);
                if($val){
                    $pn->value = $val;
                    $pn->save();
                }
                echo $replaced.' '.$model->title_en.' DONE! CARB: '.$val."\n";
            }
        }

    }

    public function actionNuttabCarbon(){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/parser_files/nuttab/nuttad');
        ini_set('max_execution_time', -1);

        foreach($data as $product){
            if($product['Nutrient ID'] == 'AVAILCHO') {
                $replaced = 'UPD';
                $model = Product::findOne(['ndb_slug' => 'nuttab', 'ndb_id' => $product['Food ID']]);
                if ($model) {
                    ProductNutrient::deleteAll([
                        'product_id'=>$model->id,
                        'nutrient_id'=>10
                    ]);
                    $pn = new ProductNutrient();
                    $pn->product_id = $model->id;
                    $pn->nutrient_id = 10;
                    $val = (float)str_replace(',', '.', $product['Value']);
                    if ($val) {
                        $pn->value = $val;
                        $pn->save();
                    }
                    echo $replaced . ' ' . $model->title_en . ' DONE! CARB: ' . $val . "\n";
                }
            }
        }

    }


    public function actionCnfRestore(){
        $data = \moonland\phpexcel\Excel::import(Yii::getAlias('@webroot').'/parser_files/seqaf.csv');
        ini_set('max_execution_time', -1);

        foreach($data as $k => $product){
            $model = Product::findOne(['ndb_id'=>$product['FoodID'], 'ndb_slug'=>'cnf']);
            $nutrient = TestNutrient::findOne(['cnf'=>$this->findSlug($product['NutrientID'])]);

            if($nutrient && $model){
                $val = (float)$product['NutrientValue'];
                if($val){
                    $pn = ProductNutrient::findOne(['product_id'=>$model->id,'nutrient_id'=>$nutrient->id]);
                    if(!$pn){
                        $pn = new ProductNutrient();
                        $pn->product_id = $model->id;
                        $pn->nutrient_id = $nutrient->id;
                        $pn->value = $val;
                        $pn->save();
                        echo ' '.$model->id.' ';
                    } else {
                        echo '.';
                    }
                }
            }

        }

        return 1;
    }

    public function actionLink(){
        $parents = Product::findAll(['related_id'=>0]);
        echo count($parents)."\n";
        foreach($parents as $parent){
            echo $parent->id."\n";
            $nutrients = $parent->getNutrients()->asArray()->all();
            foreach($parent->related as $related){
                echo $related->id."\n";
                $nutrients = ArrayHelper::merge($nutrients, $related->getNutrients()->asArray()->all());
                ProductNutrient::deleteAll(['product_id'=>$parent->id]);
                ProductNutrient::deleteAll(['product_id'=>$related->id]);
                $mapped = ArrayHelper::map($nutrients, 'product_id', 'value', 'nutrient_id');
                foreach($mapped as $id => $nutrientArr){
                    $productNutrient = new ProductNutrient();
                    $productNutrient->product_id = $parent->id;
                    $productNutrient->nutrient_id = $id;
                    $productNutrient->value = max($nutrientArr);
                    $productNutrient->save();
                    echo max($nutrientArr)."\n";
                }
                $related->delete();
            }
        }
    }

}