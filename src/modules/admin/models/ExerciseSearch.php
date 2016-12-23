<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Exercise;

/**
 * ExerciseSearch represents the model behind the search form of `app\models\Exercise`.
 */
class ExerciseSearch extends Exercise
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plane', 'type', 'head_down', 'axis_power', 'trauma', 'ccal'], 'integer'],
            [['title', 'photo', 'video', 'equipment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Exercise::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'plane' => $this->plane,
            'type' => $this->type,
            'head_down' => $this->head_down,
            'axis_power' => $this->axis_power,
            'trauma' => $this->trauma,
            'ccal' => $this->ccal,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'equipment', $this->equipment]);

        return $dataProvider;
    }
}
