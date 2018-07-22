<?php

namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Search model for products summary table
 */
class ProductSummarySearch extends Product
{
    /**
     * "group by" settings
     */
    const
        GRP_BY_PROVIDER = 1,
        GRP_BY_CATEGORY = 2;

    /**
     * Relation property name, which field `title` will be used for grouping
     */
    private $groupEntity = [
        self::GRP_BY_PROVIDER => 'provider',
        self::GRP_BY_CATEGORY => 'category',
    ];

    /**
     * Attribute "groupBy" value. See self::GRP_BY_*
     *
     * @var int 
     */
    public $groupBy;

    /**
     * The name of the attribute associated with "groupBy" selection in the form. It is needed out there for Grid View.
     * 
     * category.title | provider.title
     *
     * @var string
     */
    public $groupAttribute;
    
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
            [['title', 'category.title', 'provider.title'], 'safe'],
            ['groupBy', 'in', 'range' => [static::GRP_BY_PROVIDER, static::GRP_BY_CATEGORY]],
        ];
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => Yii::$app->params['perPage'],
            ],
        ]);

        $this->load($params);
        // It ignores by load() for some reason.
        $this->groupBy = $params['groupBy'] ?? static::GRP_BY_PROVIDER;

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
                'products.id' => $this->id,
                'price'       => $this->price,
            ])
            ->andFilterWhere(['like', 'title', $this->title]);

        $this->addTitleRelation('category', $dataProvider, $query);
        $this->addTitleRelation('provider', $dataProvider, $query);

        
        $this->groupAttribute = $this->getGroupAttributeName();
        $query->orderBy($this->groupAttribute);

        return $dataProvider;
    }

    /**
     * Get name of grouping attribute
     *
     * @return string
     */
    private function getGroupAttributeName(): string
    {
        return $this->groupEntity[$this->groupBy] . '.title';
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
        $attr = $property . '.title';

        // Sort
        $dataProvider->sort->attributes[$attr] = [
            'asc'  => [$attr => SORT_ASC],
            'desc' => [$attr => SORT_DESC],
        ];

        $query->joinWith([
            $property => function ($query) use ($property, $table) {
                $query->from([$property => $table]);
            },
        ]);

        // Search
        $query->andFilterWhere(['LIKE', $attr, $this->getAttribute($attr)]);
    }
}
