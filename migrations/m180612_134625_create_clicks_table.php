<?php

use yii\db\Migration;

/**
 * Handles the creation of table `clicks`.
 */
class m180612_134625_create_clicks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('clicks', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),
            'clientId' => $this->string(),
            'unique_clicks' => $this->integer(),
            'clicks' => $this->integer(),
            'country_code' => $this->string(),
            'date' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('clicks');
    }
}
