<?php

namespace app\modules\admin;

use nullref\admin\interfaces\IMenuBuilder;
use nullref\core\components\Module as BaseModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\InvalidConfigException;

class Module extends \nullref\admin\Module implements IAdminModule
{
    public static function getAdminMenu()
    {
        return [
            'label' => 'Панель управления',
            'items'=> [
                [
                    'label' => 'Администраторы',
                    'url' => ['/admin/user'],
                ],
                [
                    'label' => 'Перевод',
                    'url' => ['/admin/product/translation'],
                ],
                [
                    'label' => 'Продукты',
                    'url' => ['/admin/product'],
                ],
								[
										'label' => 'Группы продуктов',
										'url' => ['/admin/group'],
								],
								[
										'label' => 'Упражнения',
										'items'=> [
												[
														'label' => 'Мышцы',
														'url' => ['/admin/muscle'],
												],
												[
														'label' => 'Упражнения',
														'url' => ['/admin/exercise'],
												],
										],
								],
            ]
        ];
    }


}
