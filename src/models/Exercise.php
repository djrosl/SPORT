<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exercise".
 *
 * @property integer $id
 * @property string $title
 * @property string $photo
 * @property string $video
 * @property string $equipment
 * @property integer $plane
 * @property integer $type
 * @property integer $head_down
 * @property integer $axis_power
 * @property integer $trauma
 * @property integer $ccal
 */
class Exercise extends \yii\db\ActiveRecord
{


	const EQUIPMENT = [
			0=>"тренажер",
			1=>"штанга",
			2=>"гантели",
			3=>"гири",
			4=>"свой вес",
			5=>"TRX",
			6=>"турник",
			7=>"брусья",
			8=>"кольца",
			9=>"мяч",
			10=>"bosu",
			11=>"скамья",
			12=>"жгуты",
			13=>"скакалка",
			14=>"степ",
			15=>"фитбол",
			16=>"bodybar",
			17=>"бассейн",
			18=>"велосипед",
            19=>"кроссовер",
            20=>"эспандер",
	];

	const CAPACITIES = [
			"компрессионное горизонтальное",
			"компрессионное вертикальное",
			"декомпрессионное горизонтальное",
			"декомпрессионное вертикальное",
	];

	const DIRECTIONS = [
	    0=>'На массу',
        1=>'На рельеф',
        2=>"скорость",
        3=>"растяжка",
        4=>"сила",
        5=>"выносливость",
        6=>"ловкость"
    ];

    const PHASES = [
        0=>"однофазное",
        1=>"двухфазное",
        2=>"трехфазное",
        3=>"четырехфазное",
        4=>"пятифазное",
    ];

	const PLANE_HORIZONTAL = 1;
	const PLANE_SAGITAL = 2;


	const TYPE_BASE = 1;
	const TYPE_ISOLATE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exercise';
    }

	public function behaviors()
	{
		return [
				[
						'class' => \voskobovich\linker\LinkerBehavior::className(),
						'relations' => [
								'basic' => 'basic',
								'stability' => 'stability',
								'synergy' => 'synergy',
						],
				],
				'image' => [
						'class' => 'rico\yii2images\behaviors\ImageBehave',
				]
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['plane', 'type', 'head_down', 'axis_power', 'trauma', 'ccal', 'capacity', 'phase'], 'integer'],
						[['basic', 'stability', 'synergy', 'direction'], 'safe'],
            [['title','title_short','title_en', 'equipment', 'target'], 'string', 'max' => 255],
						[['photo', 'video'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Полное Название',
            'title_short' => 'Краткое Название',
            'photo' => 'Фото',
            'video' => 'Видео',
            'equipment' => 'Оборудование',
            'plane' => 'Ось',
            'phase' => 'Фазы',
            'type' => 'Тип',
            'head_down' => 'Голова ниже корпуса',
            'axis_power' => 'Осевая нагрузка',
            'trauma' => 'Повышенная травмоопасность',
            'ccal' => 'Трата килокалорий',
						'target' => 'целевая группа мышц',
						'basic' => 'основные рабочие мышцы',
						'synergy' => 'мышцы-синергисты',
						'stability' => 'мышцы-стабилизаторы',
        ];
    }

    /*public function getTarget() {
    	return $this->hasMany(Muscle::className(), [
    			'id'=>'muscle_id'
			])->viaTable('muscle_exercise_target', [
					'exercise_id'=>'id'
			]);
		}*/

	public function getBasic() {
		return $this->hasMany(Muscle::className(), [
				'id'=>'muscle_id'
		])->viaTable('muscle_exercise_basic', [
				'exercise_id'=>'id'
		]);
	}

	public function getStability() {
		return $this->hasMany(Muscle::className(), [
				'id'=>'muscle_id'
		])->viaTable('muscle_exercise_stability', [
				'exercise_id'=>'id'
		]);
	}

	public function getSynergy() {
		return $this->hasMany(Muscle::className(), [
				'id'=>'muscle_id'
		])->viaTable('muscle_exercise_synergy', [
				'exercise_id'=>'id'
		]);
	}

	public function getCapacityName(){
	    return $this::CAPACITIES[(int)$this->capacity];
    }

    public function getEquipName(){
        return $this::EQUIPMENT[(int)$this->equipment];
    }
}
