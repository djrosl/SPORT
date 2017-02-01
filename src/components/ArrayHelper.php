<?php
/**
 */

namespace app\components;


class ArrayHelper extends \yii\helpers\ArrayHelper
{

    public static function mapAdvanced($array){
        $arr = self::map($array, 'id', 'title');

        foreach($arr as $item){

        }

    }

}