<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Exercise */

$this->title = 'Create Exercise';
$this->params['breadcrumbs'][] = ['label' => 'Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
