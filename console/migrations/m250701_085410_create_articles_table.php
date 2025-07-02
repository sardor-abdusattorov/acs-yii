<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articles}}` and `{{%articles_translations}}`.
 */
class m250701_085410_create_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(255)->null(),
            'slug' => $this->string(255)->null(),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%articles_translations}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255)->notNull(),
            'content' => $this->text()->null(),
        ]);

        $this->addForeignKey(
            'fk-articles_translations-article_id',
            '{{%articles_translations}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-articles_translations-article_id-language',
            '{{%articles_translations}}',
            ['article_id', 'language'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-articles_translations-article_id', '{{%articles_translations}}');
        $this->dropIndex('idx-articles_translations-article_id-language', '{{%articles_translations}}');
        $this->dropTable('{{%articles_translations}}');
        $this->dropTable('{{%articles}}');
    }
}
