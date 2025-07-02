<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m250527_094752_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица menu
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(255)->defaultValue(null),
            'position' => $this->tinyInteger()->defaultValue(1),
            'parent_id' => $this->integer()->defaultValue(null),
            'order_by' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Таблица menu_translations
        $this->createTable('{{%menu_translations}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
        ]);

        // Внешний ключ
        $this->addForeignKey(
            'fk-menu_translations-menu_id',
            '{{%menu_translations}}',
            'menu_id',
            '{{%menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешний ключ
        $this->dropForeignKey('fk-menu_translations-menu_id', '{{%menu_translations}}');

        // Удаляем таблицы
        $this->dropTable('{{%menu_translations}}');
        $this->dropTable('{{%menu}}');
    }
}
