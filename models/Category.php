<?php
namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Categories model
 *
 * @property int       $id
 * @property string    $title       Category name
 * @property string    $description Category description
 * @property int       $sequence    Order of show
 * @property int       $is_visible  Visibility
 * @property string    $created_at
 * @property string    $updated_at
 *
 * @property Product[] $products
 */
class Category extends ActiveRecord
{
    use TimestampTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 45],
            [['description'], 'string'],
            [['sequence',], 'integer'],
            [['is_visible'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'          => 'ID',
            'title'       => 'Category name',
            'description' => 'Category description',
            'sequence'    => 'Order of show',
            'is_visible'  => 'Visibility',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    /**
     * Get products
     *
     * @return ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }
}
