<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}` and its translations.
 */
class m250701_054334_create_books_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(255)->null(),
            'file' => $this->string(255)->null(),
            'link' => $this->string(255)->defaultValue(null),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%books_translations}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),

            'author' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),

            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_books_translations_book_id',
            '{{%books_translations}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_books_translations_book_id', '{{%books_translations}}');
        $this->dropTable('{{%books_translations}}');
        $this->dropTable('{{%books}}');
    }
}
