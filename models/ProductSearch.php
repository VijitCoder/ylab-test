<?php

namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public function attributes()
    {
        return array_merge(parent::attributes(), ['category.title', 'provider.title']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'category_id', 'provider_id'], 'integer'],
            ['price', 'match', 'pattern' => '/^\d+(\.\d{1,2})?$/'],
            [['title', 'description', 'image', 'created_at', 'updated_at', 'category.title', 'provider.title'], 'safe'],
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
     * @throws InvalidArgumentException
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['perPage'],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'          => $this->id,
            'price'       => $this->price,
            'category_id' => $this->category_id,
            'provider_id' => $this->provider_id,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        $this->addTitleRelation('category', $dataProvider, $query);
        $this->addTitleRelation('provider', $dataProvider, $query);
        
        return $dataProvider;
    }

    /**
     * Setting up sort and search in related tables.
     *
     * Note: see also additions in self::attributes() and self::rules()
     *
     * @param string             $property category|provider
     * @param ActiveDataProvider $dataProvider
     * @param ActiveQuery        $query
     * @return void
     */
    private function addTitleRelation(string $property, ActiveDataProvider $dataProvider, ActiveQuery $query): void
    {
        // Map: relation property in the Product model => relation table name
        $map = [
            'category' => 'categories',
            'provider' => 'providers',
        ];
        
        $table = $map[$property];
        $field = $property . '.title';
        
        // Sort
        $dataProvider->sort->attributes[$field] = [
            'asc'  => [$field => SORT_ASC],
            'desc' => [$field => SORT_DESC],
        ];

        $query->joinWith([
            $property => function ($query) use ($property, $table) {
                $query->from([$property => $table]);
            },
        ]);

        // Search
        $query->andFilterWhere(['LIKE', $field, $this->getAttribute($field)]);
    }
}
