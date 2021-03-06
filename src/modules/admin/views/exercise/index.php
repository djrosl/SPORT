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


$post = Yii::$app->request->post();

if(!empty($post['is_filter'])):

    $query = Exercise::find()->orderBy('title');
    unset($post['_csrf']);
    unset($post['is_filter']);
    foreach($post as $k=>$filter){
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

    <?php ActiveForm::begin([]); ?>
    <div class="form-group">
    <?=Html::dropDownList('target', !empty($post['target']) ? $post['target'] : null, $targets,['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>
    <input type="hidden" name="is_filter" value="true">
    <div class="form-group">
    <?=Html::dropDownList('equipment', !empty($post['equipment']) ? $post['equipment'] : null, Exercise::EQUIPMENT, ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>
    <div class="form-group">
    <?=Select2::widget([
        'data'=>$muscles,
        'name'=>'muscle',
        'value'=>!empty($post['muscle']) ? $post['muscle'] : [],
        'options' => [
            'placeholder' => 'Выбрать',
            'multiple'=>true
        ],
    ])?>
    </div>

    <div class="form-group">
        <?=Html::dropDownList('type', !empty($post['type']) ? $post['type'] : null, [
            Exercise::TYPE_BASE=>'Односуставное',
            Exercise::TYPE_ISOLATE=>'Многосуставное',
        ], ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>

    <div class="form-group">
        <?=Html::dropDownList('capacity', !empty($post['capacity']) ? $post['capacity'] : null, Exercise::CAPACITIES, ['class'=>'form-control','prompt'=>'Выбрать'])?>
    </div>

    <div class="form-group">
        <?=Html::checkbox('head_down',!empty($post['head_down']) ? $post['head_down'] : null, [])?> Голова ниже корпуса
    </div>
    <div class="form-group">
        <?=Html::checkbox('axis_power',!empty($post['axis_power']) ? $post['axis_power'] : null, [])?> Осевая нагрузка
    </div>
    <div class="form-group">
        <?=Html::checkbox('trauma',!empty($post['trauma']) ? $post['trauma'] : null, [])?> Повышенная травмоопасность
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
