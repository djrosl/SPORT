<?php

use app\components\ArrayHelper;
use app\models\Exercise;
use app\models\Muscle;
use app\models\ProductGroup;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ExerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exercises';
$this->params['breadcrumbs'][] = $this->title;

$targets = ArrayHelper::map(Muscle::find()->groupBy(['group'])->all(), 'group', 'group');

$muscles = ArrayHelper::merge(
    ArrayHelper::map(Muscle::find()->all(), 'id', 'title_ru'),
    ArrayHelper::map(Muscle::find()->all(), 'id', 'title_lat')
);


$get = Yii::$app->request->get();

if(!empty($get['is_filter'])):

    $query = Exercise::find();
    unset($get['is_filter']);
    unset($get['ExerciseSearch']);
    foreach($get as $k=>$filter){
        if($filter){
            if($k == 'muscle'){
                $query->joinWith('basic')->andWhere(['in', 'muscle_exercise_basic.muscle_id', $filter]);
            } else {
                $query->andWhere(['exercise.'.$k=>$filter]);
            }
        }
    }

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 100,
        ],
    ]);
endif;
?>
<div class="exercise-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Exercise', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php ActiveForm::begin([
            'method'=>'GET'
    ]); ?>
    <div class="form-group">
    <?=Html::dropDownList('target', 0, $targets,['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>
    <input type="hidden" name="is_filter" value="true">
    <div class="form-group">
    <?=Html::dropDownList('equipment', null, Exercise::EQUIPMENT, ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>
    <div class="form-group">
    <?=Select2::widget([
        'data'=>$muscles,
        'name'=>'muscle',
        'options' => [
            'placeholder' => 'Выбрать',
            'multiple'=>true
        ],
    ])?>
    </div>

    <div class="form-group">
        <?=Html::dropDownList('type', 0, [
            Exercise::TYPE_BASE=>'Односуставное',
            Exercise::TYPE_ISOLATE=>'Многосуставное',
        ], ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>

    <div class="form-group">
        <?=Html::dropDownList('capacity', null, Exercise::CAPACITIES, ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>

    <div class="form-group">
        <?=Html::checkbox('head_down',false, [])?> Голова ниже корпуса
    </div>
    <div class="form-group">
        <?=Html::checkbox('axis_power',false, [])?> Осевая нагрузка
    </div>
    <div class="form-group">
        <?=Html::checkbox('trauma',false, [])?> Повышенная травмоопасность
    </div>

    <div class="form-group text-right">
        <a href="<?=Url::to(['exercise/index'])?>" class="btn btn-danger">Очистить</a>
        <button class="btn btn-success">Фильтр</button>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            [
                'attribute'=>'capacity',
                'value'=>function($model){
                    return $model->getCapacityName();
                }
            ],
            [
                'attribute'=>'equipment',
                'value'=>function($model){
                    return $model->getEquipName();
                }
            ],
            // 'plane',
            // 'type',
            // 'head_down',
            // 'axis_power',
            // 'trauma',
            // 'ccal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
