<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 8:54
 */
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $group->title;
?>

<div class="admin-index">
	<div class="row">
		<div class="col-lg-12">
			<h1><?=$group->title?> </h1>

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

        <div class="col-lg-12">
            <div class="text-right">
                <?=Html::a('Добавить продукты', Url::to(['index', 'group'=>$group->id]))?>
                &nbsp;
                &nbsp;
                &nbsp;
                <?=Html::a('Удалить группу', Url::to(['delete', 'group'=>$group->id]), ['class'=>'text-danger'])?>
            </div>
        </div>


		<!-- /.col-lg-12 -->

        <?php $dataProvider = new ActiveDataProvider([
            'query' => $group->getProducts(),
            'pagination' => [
                'pageSize' => 10000,
            ],
        ]); ?>

            <?=GridView::widget([
                'dataProvider'=>$dataProvider,
                'columns'=>[
                    'product.title_en',
                    [
                        'label'=>'Нутриенты',
                        'format'=>'html',
                        'value'=>function($item){
                            //var_dump($item->product->id);die;
                            return Html::a('Показать нутриенты', '', ['title'=>$item->product->id, 'class'=>'text-info show-nutrients']);
                        }
                    ],
                    [
                        'label'=>'Удалить',
                        'format'=>'html',
                        'value'=>function($item) use ($group){
                            return Html::a('Удалить', Url::to(['delete-product-from-group', 'group'=>$group->id, 'product'=>$item->id]), ['class'=>'text-danger']);
                        }
                    ],
                ]
            ])?>
	</div>
	<!-- /.row -->
</div>