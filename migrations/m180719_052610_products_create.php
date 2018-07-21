<?php

use yii\db\Migration;

/**
 * Create products table
 */
class m180719_052610_products_create extends Migration
{
    public function up()
    {
        $this->createTable('products', [
            'id'          => $this->bigPrimaryKey()->unsigned(),
            'title'       => $this->string(45)->notNull()->comment('Product name'),
            'description' => $this->text()->comment('Product description'),
            'price'       => $this->decimal(5, 2)->commeny('Price'),
            'image'       => $this->string(100)->comment('Relative URL to the product image'),
            'category_id' => $this->integer()->unsigned()->notNull(),
            'provider_id' => $this->integer()->unsigned()->notNull(),
            'created_at'  => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at'  => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(
            'category_idx',
            'products',
            'category_id'
        );

        $this->addForeignKey(
            'fk_product_category',
            'products',
            'category_id',
            'categories',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex(
            'provider_idx',
            'products',
            'provider_id'
        );

        $this->addForeignKey(
            'fk_product_provider',
            'products',
            'provider_id',
            'providers',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_product_category', 'products');
        $this->dropForeignKey('fk_product_provider', 'products');
        $this->dropTable('products');
    }
}
