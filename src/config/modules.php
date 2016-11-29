<?php

return array_merge(require(__DIR__ . '/installed_modules.php'), [
   'core' => ['class' => 'nullref\core\Module'],
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
]);