<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 8:54
 */
use app\models\Product;
use app\models\ProductGroup;
use app\models\ProductToGroup;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $group->title;

$array = ArrayHelper::map( ProductGroup::find()->all(), 'id', 'title');

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
                <?=Html::a('Подгруппы', Url::to(['sub', 'id'=>$group->id]))?>
                &nbsp;
                &nbsp;
                &nbsp;
                <?=Html::a('Добавить продукты', Url::to(['index', 'group'=>$group->id]))?>
                &nbsp;
                &nbsp;
                &nbsp;
                <?=Html::a('Удалить группу', Url::to(['delete', 'group'=>$group->id]), ['class'=>'text-danger'])?>
            </div>
            <br><br>
        </div>


		<!-- /.col-lg-12 -->

                <form action="" method="get" class="marged form-group">
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="search" value="<?=$search?>">
                        <input type="hidden" name="id" value="<?=$group->id?>">
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-success">Искать</button>
                    </div>
                    <br><br>
                </form>




        <?php
        if(!$search) {
            $query = $group->getProducts();
            $anotherDataProvider = false;
        } else {
            $query = $group->getProducts()->where(['like','title_en', $search]);
            $another_query = ProductToGroup::find()->joinWith('product')->where(['like','title_en', $search])->andWhere(['!=','group_id',$group->id])->orderBy('group_id');

            $anotherDataProvider = new ActiveDataProvider([
                'query' => $another_query,
                'pagination' => [
                    'pageSize' => 100,
                ],
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->joinWith('product'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort'=>[
                'product.ndb_slug'=>[
                    'asc' => ['product.ndb_slug' => SORT_ASC],
                    'desc' => ['product.ndb_slug' => SORT_DESC],
                ]
            ]
        ]); ?>

        <?php ActiveForm::begin([

        ]); ?>

            <?=GridView::widget([
                'dataProvider'=>$dataProvider,
                'columns'=>[
                    ['class' => 'yii\grid\CheckboxColumn'],

                    'product.title_en',
                    'product.ndb_slug',

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

            <div class="bottom row">
                <div class="col-md-3">
                    <?=Html::dropDownList('action', 0, ['move'=>'Переместить', 'delete'=>"Удалить"], ['class'=>'form-control'])?>
                </div>
                <div class="col-md-3">
                    <?=Html::dropDownList('group', 0,
                        ArrayHelper::map(ProductGroup::find()->all(), 'id', 'title')
                        , ['class'=>'form-control'])?>
                </div>
                <div class="col-md-3">
                    <?=Html::submitButton('OK', ['class'=>'btn btn-success'])?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

<?php if($anotherDataProvider): ?>
        <h4>Продукты из других групп</h4>

        <?php ActiveForm::begin([

        ]); ?>

        <?=GridView::widget([
            'dataProvider'=>$anotherDataProvider,
            'columns'=>[
                ['class' => 'yii\grid\CheckboxColumn'],

                'product.title_en',
                'group.title',
                'product.ndb_slug',

                [
                    'label'=>'Нутриенты',
                    'format'=>'html',
                    'value'=>function($item){
                        //var_dump($item->product->id);die;
                        return Html::a('Показать нутриенты', '', ['title'=>$item->id, 'class'=>'text-info show-nutrients']);
                    }
                ],
            ]
        ])?>

    <div class="bottom row">
        <div class="col-md-3">
            <?=Html::dropDownList('action', 0, ['move'=>'Переместить', 'delete'=>"Удалить"], ['class'=>'form-control'])?>
        </div>
        <div class="col-md-3">
            <?=Html::dropDownList('group', 0,
                $array
                , ['class'=>'form-control'])?>
        </div>
        <div class="col-md-3">
            <?=Html::submitButton('OK', ['class'=>'btn btn-success'])?>
        </div>
    </div>

        <?php ActiveForm::end(); ?>
<?php endif; ?>



	</div>
	<!-- /.row -->
</div>