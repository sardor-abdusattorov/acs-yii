<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%archive_news}}` and `{{%archive_news_translation}}`.
 */
class m250721_060853_create_archive_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%archive_news}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string()->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%archive_news_translation}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'language' => $this->string(8)->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%archive_news_translation}}');
        $this->dropTable('{{%archive_news}}');
    }
}
