<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">


                <?php foreach($models as $model): ?>
            <div class="col-md-6">
                    <h3><?=$model->title_en?> (<?=$model->ndb_slug?>)</h3>
                    <div style="height: 400px;overflow-y:scroll">
                    <table class="table table-bordered">
                        <?php foreach($model->getNutrients()->orderBy('nutrient_id ASC')->all() as $nutrient) {
                            echo "<tr>";

                            $value = $nutrient->value;
                            echo "<td>{$nutrient->parent->title_ru}</td>";
                            echo "<td>$value</td>";
                            echo "<td>{$nutrient->parent->unit}</td>";
                            echo "</tr>";
                        } ?>
                    </table>
                    </div>
            </div>
                <?php endforeach; ?>

    </div>

</div>
