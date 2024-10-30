<?php

namespace common\models;

use common\components\Utils;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Blog;

/**
 * BlogSearch represents the model behind the search form of `common\models\Blog`.
 */
class BlogSearch extends Blog
{
    /**
     * {@inheritdoc}
     */
    public $author;
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['image', 'title', 'body','author', 'created_at', 'updated_at'], 'safe'],
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
        $query = Blog::find();
        $query->joinWith('user');
//        Utils::printAsError($query);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        Utils::printAsError($dataProvider);
        $dataProvider->sort->attributes['author'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'blog.id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['blog.id' => $this->id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like','user.username', $this->author])
            ->andFilterWhere(['like', 'body', $this->body]);

//        Yii::debug($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
