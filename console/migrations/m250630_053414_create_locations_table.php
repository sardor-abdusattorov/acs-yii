<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%locations}}`.
 */
class m250630_053414_create_locations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%locations}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'image' => $this->string(255)->null(),
            'status' => $this->tinyInteger(2)->defaultValue(1)->comment('Статус'),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата создания'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('Дата обновления'),
        ]);

        $this->createTable('{{%location_translation}}', [
            'id' => $this->primaryKey(),
            'location_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull()->comment('Заголовок'),
            'content' => $this->text()->null()->comment('Контент'),
        ]);

        $this->createTable('{{%location_images}}', [
            'id' => $this->primaryKey(),
            'location_id' => $this->integer()->notNull(),
            'image' => $this->string(255)->notNull()->comment('Путь к изображению'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата создания'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('Дата обновления'),
        ]);

        $this->addForeignKey(
            'fk-location_translation-location_id',
            '{{%location_translation}}',
            'location_id',
            '{{%locations}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-location_images-location_id',
            '{{%location_images}}',
            'location_id',
            '{{%locations}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-location_translation-language', '{{%location_translation}}', 'language');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-location_images-location_id', '{{%location_images}}');
        $this->dropForeignKey('fk-location_translation-location_id', '{{%location_translation}}');
        $this->dropIndex('idx-location_translation-language', '{{%location_translation}}');
        $this->dropTable('{{%location_images}}');
        $this->dropTable('{{%location_translation}}');
        $this->dropTable('{{%locations}}');
    }
}
