<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'ndb_id',
            //'category_id',
            //'diet_type_id',
            //'slug',
            [
                'label'=>'title_en',
                'format'=>'html',
                'value'=>function($model){
                    if($model):
                        return is_null($model->related_id) ? $model->title_en :
                            $model->title_en.' ['.Html::a('группа', \yii\helpers\Url::to(['/admin/product/group', 'id'=>$model->id]),[
                                'class'=>'open_subgrp'
                            ]).']'.
                            '<div class="subgrp">'.implode("<br>", array_map(function($item){
                                return $item->title_en." ".$item->ndb_slug;
                            }, $model->related)).'</div>';
                    endif;
                    return '';
                }
            ],

            [
                'attribute'=>'title_ru',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::textarea("titles[{$model->id}]", $model->title_ru, ['class'=>'form-control']).Html::button('OK', ['class'=>'saveTranslation btn btn-info','data'=>['id'=>$model->id]]);
                }

             ],
             'ndb_slug',
            /*[
                'attribute' => 'group',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Группа: '.count($model->related), ['product/group?id='.$model->id]);
                },
            ],*/
            // 'image',
            // 'description_short:ntext',
            // 'description_full:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <style>
        .subgrp {
            display: none;
            padding-left: 40px;
            padding-top: 20px;
        }
    </style>

</div>
