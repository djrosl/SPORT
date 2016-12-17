<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 7:32
 */

use app\modules\admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Поиск / добавление в группу'; ?>

<div class="admin-index">
    <div class="row">
        <div class="col-lg-12">

          <?php $form = ActiveForm::begin([]); ?>
            <div class="row">
                <div class="col-lg-10">
                    <div class="form-group">
                      <?=Html::input('text', 'search', !empty($search) ? $search : "", ['class'=>'form-control','placeholder'=>'Введите название продукта'])?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <?=Html::submitButton('Поиск', ['class'=>'btn btn-info'])?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <?php if(!empty($models)): ?>
        <?php $group = ActiveForm::begin([
          'action'=>Url::to(['save-group'])
        ]); ?>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td><input type="checkbox" name="" id="all"> <label for="all">Выбрать все</label></td>
                    <td>Название</td>
                    <td>База</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($models as $model): ?>
                <tr>
                    <td><input type="checkbox" name="product[<?=$model->id?>]" value="<?=$model->id?>" id="p<?=$model->id?>"></td>
                    <td><label for="p<?= $model->id ?>"><?=$model->title_en?></label></td>
                    <td><?=$model->ndb_slug?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
      <div class="row">
          <div class="col-md-12"><h4>Название группы продуктов</h4></div>
          <div class="col-md-6">
              <div class="form-group">
                  <input type="text" class="form-control" name="name" value="<?=$search?>">
              </div>
          </div>
          <div class="col-md-6">
              <button class="btn btn-success">Сохранить</button>
          </div>
      </div>
        <?php ActiveForm::end(); ?>
		<?php else: ?>
        <table class="table table-bordered">
            <tbody>
            <?php foreach($groups as $group): ?>
            <tr>
                <td><a href="<?=Url::to(['group/view', 'id'=>$group->id])?>"><?=$group->title?></a></td>
                <td><?=$group->getProducts()->count()?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>




</div>
