<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180522_194543_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'picture' => $this->string(),
            'teaser' => $this->string(),
            'content' => $this->text(),
            'date' => $this->date(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
