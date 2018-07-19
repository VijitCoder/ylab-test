<?php

use yii\db\Migration;

/**
 * Create categories table
 */
class m180719_045549_categories_create extends Migration
{
    public function up()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(45)->notNull()->comment('Category name'),
            'description' => $this->text()->comment('Category description'),
            'sequence' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('Order of show'),
            'is_visible' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('Visibility'),
            'created_at' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    public function down()
    {
        $this->dropTable('categories');
    }
}
