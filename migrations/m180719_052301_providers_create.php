<?php

use yii\db\Migration;

/**
 * Create providers table
 */
class m180719_052301_providers_create extends Migration
{
    public function up()
    {
        $this->createTable('providers', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(45)->notNull()->comment('Provider name'),
            'sequence' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('Order of show'),
            'created_at' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    public function down()
    {
        $this->dropTable('providers');
    }
}
