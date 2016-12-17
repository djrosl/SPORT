<?php
/**
 * Created by PhpStorm.
 * User: rosl
 * Date: 17.12.16
 * Time: 8:07
 */

namespace app\modules\admin\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
	];
	public $js = [
			'admin/js/main.js',
	];
	public $depends = [
			'yii\web\YiiAsset',
	];
}