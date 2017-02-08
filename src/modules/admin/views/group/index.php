<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 7:32
 */

use app\models\ProductGroup;
use app\models\ProductToGroup;
use app\modules\admin\assets\AdminAsset;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
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

    <?php if(!empty($models) || !empty($exist)): ?>
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

            </tbody>
            <tbody>
                <?php foreach($models as $model): ?>
                <tr>
                    <td><input type="checkbox" name="product[<?=$model['id']?>]" value="<?=$model['id']?>" id="p<?=$model['id']?>"></td>
                    <td><label for="p<?= $model['id'] ?>"><?=$model['title_en']?></label></td>
                    <td><?=$model['ndb_slug']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
      <div class="row">
          <div class="col-md-12"><h4>Название группы продуктов</h4></div>
          <div class="col-md-6">
              <div class="form-group">
                  <input type="hidden" name="groupExist" value="<?=Yii::$app->request->get('group') ? Yii::$app->request->get('group') : false?>">
                  <input type="text" class="form-control" name="name" value="<?=$title ? $title : $search?>">
              </div>
          </div>
          <div class="col-md-6">
              <button class="btn btn-success">Сохранить</button>
          </div>
      </div>
        <?php ActiveForm::end(); ?>
		<?php endif; ?>


    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => ProductGroup::find(),
        'pagination' => [
            'pageSize' => 100,
        ],
    ]); ?>
    <?=GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=>[
            'title',
            [
                'label'=>'Ссылка',
                'format'=>'html',
                'value'=>function($group){
                    //var_dump($item->product->id);die;
                    return Html::a('Перейти', Url::to(['group/view', 'id'=>$group->id]));
                }
            ],
            [
                'label'=>'Количество',
                'format'=>'html',
                'value'=>function($group){
                    //var_dump($item->product->id);die;
                    return Html::tag('span', $group->getProducts()->count());
                }
            ],
        ]
    ])?>


    <?php if(!empty($groupModels)): ?>
    <h2>Поиск по группам</h2>
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Название</td>
                <td>Группа</td>
                <td>База</td>
            </tr>
            </thead>
            <tbody>

            </tbody>
            <tbody>
            <?php foreach($groupModels as $model): ?>
                <tr>
                    <td><label for="p<?= $model['id'] ?>"><?=$model['title_en']?></label></td>
                    <td><?php if(ProductToGroup::findOne(['product_id'=>$model['id']])): ?><a href="<?= Url::to(['view', 'id'=>ProductToGroup::findOne(['product_id'=>$model['id']])->group->id]) ?>"><?=ProductToGroup::findOne(['product_id'=>$model['id']])->group->title?></a><?php endif; ?></td>
                    <td><?=$model['ndb_slug']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>


</div>
