<?php

use app\models\Exercise;
use app\models\Muscle;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Exercise */
/* @var $form yii\widgets\ActiveForm */


$muscles = ArrayHelper::merge(
    ArrayHelper::map(Muscle::find()->all(), 'id', 'title_ru'),
    ArrayHelper::map(Muscle::find()->all(), 'id', 'title_lat')
);
$targets = ArrayHelper::map(Muscle::find()->groupBy(['group'])->all(), 'group', 'group');

?>

<div class="exercise-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'minLength'=>0,
            'source' => array_map(function($item){
                return $item->title;
            }, Exercise::find()->all()),
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]) ?>

    <?= $form->field($model, 'title_short')->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'minLength'=>0,
            'source' => array_map(function($item){
                return $item->title_short;
            }, Exercise::find()->all()),
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]) ?>

    <?= $form->field($model, 'title_en')->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'minLength'=>0,
            'source' => array_map(function($item){
                return $item->title_en;
            }, Exercise::find()->all()),
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]) ?>

    <?= $form->field($model, 'photo')->fileInput(); ?>

    <?= $form->field($model, 'video')->fileInput(); ?>

    <?= $model->video ? Html::tag('video', '', ['src'=>$model->video, 'width'=>'300', "controls"=>"controls"]) : ''; ?>

	<?= $form->field($model, 'target')->widget(Select2::className(), [
				'data' => $targets,
				'options' => [
						'placeholder' => 'Выбрать группу',
				],
    ]) ?>
	<?= $form->field($model, 'basic')->widget(Select2::className(), [
				'data' => $muscles,
				'value'=>ArrayHelper::map($model->getBasic()->all(), 'id', 'title_ru'),
				'options' => [
						'placeholder' => 'Выбрать',
						'multiple' => true
				],
        'pluginOptions' => [
            'tokenSeparators' => [', '], //space and comma are the separators
        ],
		]) ?>
	<?= $form->field($model, 'stability')->widget(Select2::className(), [
				'data' => $muscles,
				'value'=>ArrayHelper::map($model->getStability()->all(), 'id', 'title_ru'),
				'options' => [
						'placeholder' => 'Выбрать',
						'multiple' => true
				],
		]) ?>
	<?= $form->field($model, 'synergy')->widget(Select2::className(), [
				'data' => $muscles,
				'value'=>ArrayHelper::map($model->getSynergy()->all(), 'id', 'title_ru'),
				'options' => [
						'placeholder' => 'Выбрать',
						'multiple' => true
				],
		]) ?>


    <?= $form->field($model, 'equipment')->widget(Select2::className(), [
				'data' => $model::EQUIPMENT,
				'options' => [
						'placeholder' => 'Выбрать',
				],
		]) ?>

    <?= $form->field($model, 'type')->dropDownList([
				$model::TYPE_BASE=>'Многосуставное',
				$model::TYPE_ISOLATE=>'Односуставное'
		]) ?>


	<?= $form->field($model, 'capacity')->widget(Select2::className(), [
			'data' => $model::CAPACITIES,
			'options' => [
					'placeholder' => 'Выбрать',
					'multiple' => false
			],
	]) ?>
    

    <?= $form->field($model, 'phase')->widget(Select2::className(), [
        'data' => $model::PHASES,
        'options' => [
            'placeholder' => 'Выбрать',
            'multiple' => false
        ],
    ]) ?>

    <?= $form->field($model, 'direction')->widget(Select2::className(), [
        'data' => $model::DIRECTIONS,
        'options' => [
            'placeholder' => 'Выбрать',
            'multiple' => true
        ],
    ]) ?>

    <?= $form->field($model, 'head_down')->dropDownList([
				1=>'да',
				0=>'нет'
		]) ?>

    <?= $form->field($model, 'axis_power')->dropDownList([
				1=>'да',
				0=>'нет'
		]) ?>

    <?= $form->field($model, 'trauma')->dropDownList([
				1=>'да',
				0=>'нет'
		]) ?>

    <?= $form->field($model, 'ccal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
