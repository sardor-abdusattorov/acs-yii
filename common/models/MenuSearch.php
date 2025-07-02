<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Menu;

/**
 * MenuSearch represents the model behind the search form of `common\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * {@inheritdoc}
     */
    public $title;

    public function rules()
    {
        return [
            [['id', 'position', 'parent_id', 'order_by', 'status'], 'integer'],
            [['link', 'created_at', 'updated_at', 'title'], 'safe'],
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
        $query = Menu::find()->with('translations')->joinWith(['translations t']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Настройка сортировки по title
        $dataProvider->sort->attributes['title'] = [
            'asc' => ['t.title' => SORT_ASC],
            'desc' => ['t.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position' => $this->position,
            'parent_id' => $this->parent_id,
            'order_by' => $this->order_by,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link]);
        $query->andFilterWhere(['like', 't.title', $this->title])
            ->andWhere(['t.language' => Yii::$app->language]);

        return $dataProvider;
    }

}
