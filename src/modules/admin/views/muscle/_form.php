<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Muscle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="muscle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        $model::TYPE_TOP=>'Поверхностная',
        $model::TYPE_DEEP=>'Глубокая',
    ]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className()) ?>

    <?= $form->field($model, 'function')->dropDownList([
        $model::FUNCTION_PASTURAL=>'Пастуральная',
        $model::FUNCTION_PHASE=>'Фазическая',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
