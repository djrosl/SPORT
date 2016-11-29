<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            /*'id',
            'ndb_id',
            'category_id',
            'diet_type_id',
            'slug',*/
            'title_en',
            /*'title_ru',
            'image',
            'description_short:ntext',
            'description_full:ntext',*/
        ],
    ]) ?>

    <table class="table">
    <?php
        foreach($model->nutrients as $nutrient) {
            echo "<tr>";
            $value = \app\models\ProductNutrient::findOne(['product_id'=>$model->id,'nutrient_id'=>$nutrient->id])->value;
            echo "<td>$nutrient->title_ru</td>";
            echo "<td>$value</td>";
            echo "<td>$nutrient->unit</td>";
            echo "</tr>";
        }
    ?>
    </table>

</div>
