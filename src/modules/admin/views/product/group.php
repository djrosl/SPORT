<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
					<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
								/*'id',
																'ndb_id',
																'category_id',
																'diet_type_id',
																'slug',*/
									'title_en',
									'ndb_slug',
									'ndb_id',
								/*'title_ru',
																'image',
																'description_short:ntext',
																'description_full:ntext',*/
							],
					]) ?>

                <?php foreach(ArrayHelper::merge($model->related, [$model]) as $model): ?>
            <div class="col-md-6">
                    <h3><?=$model->title_en?> (<?=$model->ndb_slug?>) <a href="<?= Url::to(['/admin/product/delete-from-group', 'id' => $model->id]) ?>">удалить</a></h3>
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
