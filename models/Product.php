<?php
namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Products model
 *
 * @property int      $id
 * @property string   $title        Product name
 * @property string   $description  Product description
 * @property string   $image        Relative URL to the product image
 * @property int      $category_id
 * @property int      $provider_id
 * @property string   $created_at
 * @property string   $updated_at
 *
 * @property Category $category
 * @property Provider $provider
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'category_id', 'provider_id'], 'required'],
            [['title'], 'string', 'max' => 45],
            [['description'], 'string'],
            [['category_id', 'provider_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'string', 'max' => 100],
            [
                ['category_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Category::class,
                'targetAttribute' => ['category_id' => 'id'],
            ],
            [
                ['provider_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Provider::class,
                'targetAttribute' => ['provider_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'          => 'ID',
            'title'       => 'Product name',
            'description' => 'Product description',
            'image'       => 'Relative URL to the product image',
            'category_id' => 'Category ID',
            'provider_id' => 'Provider ID',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    /**
     * * Get product category
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Get product provider
     *
     * @return ActiveQuery
     */
    public function getProvider(): ActiveQuery
    {
        return $this->hasOne(Provider::class, ['id' => 'provider_id']);
    }
}
