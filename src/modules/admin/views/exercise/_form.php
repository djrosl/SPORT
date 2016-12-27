<?php

use app\models\Muscle;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Exercise */
/* @var $form yii\widgets\ActiveForm */


$muscles = ArrayHelper::map(Muscle::find()->all(), 'id', 'title_ru');
$targets = ArrayHelper::map(Muscle::find()->groupBy(['group'])->all(), 'group', 'group');

?>

<div class="exercise-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->fileInput(); ?>

    <?= $form->field($model, 'video')->fileInput(); ?>

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

    <?= $form->field($model, 'plane')->dropDownList([
        $model::PLANE_HORIZONTAL=>'горизонтальная',
        $model::PLANE_SAGITAL=>'сагиттальная'
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
