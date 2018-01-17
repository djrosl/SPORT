<?php

return array_merge(require(__DIR__ . '/installed_modules.php'), [
   'core' => ['class' => 'nullref\core\Module'],
		'yii2images' => [
				'class' => 'rico\yii2images\Module',
			//be sure, that permissions ok
			//if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
				'imagesStorePath' => 'files/images/store', //path to origin images
				'imagesCachePath' => 'files/images/cache', //path to resized copies
				'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
				'placeHolderPath' => '@webroot/images/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
		],
    'admin' => [
        'class' => 'app\modules\admin\Module',
        //'adminModel' => 'app\models\Admin', // admin model class
        /*'controllerMap' => [  //controllers
            'user' => 'app\modules\admin\controllers\UserController',
            'main' => 'app\modules\admin\controllers\MainController',
        ],*/
        /*'components' => [  //menu builder
            'menuBuilder' => 'app\\components\\MenuBuilder',
        ],*/
    ],
   'api' => [
	   'class' => 'app\modules\api\Module',
   ],
]);