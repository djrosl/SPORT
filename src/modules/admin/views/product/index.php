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
             'title_en',
             'title_ru',
             'ndb_slug',
            [
                'attribute' => 'group',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Группа: '.count($model->getSame()), ['product/group?id='.$model->id]);
                },
            ],
						[
								'attribute' => 'group_one',
								'format' => 'raw',
								'value' => function ($model) {
        $count = count($model->getSameOne()) > 20 ? '>'.count($model->getSameOne()) : count($model->getSameOne());
									return Html::a('Группа (без одного слова): '.$count, ['product/group?one=1&id='.$model->id]);
								},
						],
            // 'image',
            // 'description_short:ntext',
            // 'description_full:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>


</div>
