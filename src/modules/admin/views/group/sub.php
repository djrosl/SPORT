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
use unclead\multipleinput\MultipleInput;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $group->title;
?>

<div class="admin-index">
	<div class="row">
		<div class="col-lg-12">
			<h1><?=$group->title?> </h1>

            <?=Html::a('Группа', Url::to(['view', 'id'=>$group->id]))?>

<?php ActiveForm::begin();
echo MultipleInput::widget([
    'name'=>'sub',
    'data'=>$group->children,
    'columns'=>[
        [
            'name'=>'title',
            'title'=>'Название',
        ]
    ]
]);
echo Html::submitButton('Сохранить', [
        'class'=>'btn btn-success'
]);
ActiveForm::end(); ?>


		</div>
	</div>
	<!-- /.row -->
</div>