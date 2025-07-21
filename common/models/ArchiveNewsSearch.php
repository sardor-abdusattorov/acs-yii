<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArchiveNews;

/**
 * ArchiveNewsSearch represents the model behind the search form of `common\models\ArchiveNews`.
 */
class ArchiveNewsSearch extends ArchiveNews
{
    /**
     * {@inheritdoc}
     */

    public $title;
    public function rules()
    {
        return [
            [['id', 'status', 'order_by'], 'integer'],
            [['image', 'created_at', 'updated_at', 'title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ArchiveNews::find()->with('translations')->joinWith(['translations t']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['title'] = [
            'asc' => ['t.name' => SORT_ASC],
            'desc' => ['t.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'order_by' => $this->order_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image]);
        $query->andFilterWhere(['like', 't.title', $this->title])
            ->andWhere(['t.language' => Yii::$app->language]);

        return $dataProvider;
    }
}
