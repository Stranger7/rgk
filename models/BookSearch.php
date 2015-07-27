<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookSearch represents the model behind the search form about `app\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * Start date of period for book issue
     *
     * @var string
     */
    public $date_start;

    /**
     * End date of period for book issue
     *
     * @var string
     */
    public $date_end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id'], 'integer'],
            [['name', 'date_start', 'date_end'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
        ]);
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
        $query = Book::find()->joinWith('author');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'date',
                    'date_create',
                    'full_name' => [
                        'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                        'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                        'default' => SORT_DESC
                    ]
                ]
            ],
            'pagination' => ['pageSize' => 4],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (!empty($this->date_start) && empty($this->date_end)) {
            $query->andFilterWhere(['>=', 'date', $this->date_start]);
        } elseif (empty($this->date_start) &&  !empty($this->date_end)) {
            $query->andFilterWhere(['<=', 'date', $this->date_end]);
        } elseif (!empty($this->date_start) &&  !empty($this->date_end)) {
            $query->andFilterWhere(['between', 'date', $this->date_start, $this->date_end]);
        }

        return $dataProvider;
    }
}