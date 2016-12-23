<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ExerciseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exercise-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'photo') ?>

    <?= $form->field($model, 'video') ?>

    <?= $form->field($model, 'equipment') ?>

    <?php // echo $form->field($model, 'plane') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'head_down') ?>

    <?php // echo $form->field($model, 'axis_power') ?>

    <?php // echo $form->field($model, 'trauma') ?>

    <?php // echo $form->field($model, 'ccal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
