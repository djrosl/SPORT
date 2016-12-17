<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 8:54
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $group->title;
?>

<div class="admin-index">
	<div class="row">
		<div class="col-lg-12">
			<h1><?=$group->title?></h1>
		</div>
        <div class="col-lg-12">
            <?php ActiveForm::begin([]); ?>
            <div class="form-group"><input class="form-control" name="state" value="<?=$group->state?>" type="text" placeholder="Возможные состояния (home-brewed, full strength, etc.)"></div>
            <div class="form-group text-right"><button class="btn btn-info">OK</button></div>
            <?php ActiveForm::end(); ?>


            <?php if($group->state): ?>
                <div class="form-group"><?=Html::dropDownList('state_sort', null, explode(', ', 'Все, '.$group->state), ['class'=>'form-control'])?></div>
            <?php endif; ?>


        </div>
		<!-- /.col-lg-12 -->
			<?php foreach($group->products as $model): ?>
          <div class="col-md-6 prod-group-item">
              <h3><?=$model->product->title_en?> (<?=$model->product->ndb_slug?>)</h3>
              <div style="height: 400px;overflow-y:scroll">
                  <table class="table table-bordered">
										<?php foreach($model->product->getNutrients()->orderBy('nutrient_id ASC')->all() as $nutrient) {
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
	<!-- /.row -->
</div>