<?php

use yii\db\Migration;

/**
 * Handles the creation of tables for multilingual pages.
 */
class m250602_124442_create_pages_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Служебное имя страницы'),
            'slug' => $this->string()->notNull()->unique(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%page_translations}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string()->notNull(),
            'meta_title' => $this->string()->null(),
            'meta_description' => $this->text()->null(),
        ]);

        $this->addForeignKey(
            'fk_page_translations_page',
            '{{%page_translations}}',
            'page_id',
            '{{%pages}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx_page_translations_unique',
            '{{%page_translations}}',
            ['page_id', 'language'],
            true
        );

        $this->createTable('{{%page_sections}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->unique()->comment('Уникальное служебное имя секции'),
            'image' => $this->string()->null(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_page_sections_page',
            '{{%page_sections}}',
            'page_id',
            '{{%pages}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%page_section_translations}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string()->null(),
            'subtitle' => $this->string()->null(),
            'content' => 'MEDIUMTEXT NULL',
        ]);

        $this->addForeignKey(
            'fk_section_translations_section',
            '{{%page_section_translations}}',
            'section_id',
            '{{%page_sections}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx_page_section_translations_unique',
            '{{%page_section_translations}}',
            ['section_id', 'language'],
            true
        );

        $this->createTable('{{%gallery_items}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'name' => $this->string()->null()->comment('Название изображения'),
            'image' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_gallery_items_section',
            '{{%gallery_items}}',
            'section_id',
            '{{%page_sections}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_gallery_items_section', '{{%gallery_items}}');
        $this->dropForeignKey('fk_section_translations_section', '{{%page_section_translations}}');
        $this->dropForeignKey('fk_page_sections_page', '{{%page_sections}}');
        $this->dropForeignKey('fk_page_translations_page', '{{%page_translations}}');

        $this->dropTable('{{%gallery_items}}');
        $this->dropTable('{{%page_section_translations}}');
        $this->dropTable('{{%page_sections}}');
        $this->dropTable('{{%page_translations}}');
        $this->dropTable('{{%pages}}');
    }
}
