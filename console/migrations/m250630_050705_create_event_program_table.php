<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_program}}`.
 */
class m250630_050705_create_event_program_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('{{%event_program}}', [
            'id' => $this->primaryKey(),
            'day' => $this->date()->notNull()->comment('Дата проведения (день)'),
            'start_time' => $this->time()->notNull()->comment('Время начала'),
            'tag_id' => $this->integer()->null()->comment('ID тега (из справочника tags)'),
            'end_time' => $this->time()->notNull()->comment('Время окончания'),
            'location_id' => $this->integer()->null()->comment('ID локации (из справочника locations)'),
            'bg_color' => $this->string(50)->null()->comment('Фон для блока (цвет)'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%event_program_translation}}', [
            'id' => $this->primaryKey(),
            'event_program_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string(255)->null()->comment('Заголовок события'),
            'description' => $this->text()->null()->comment('Описание события'),
        ]);

        $this->addForeignKey(
            'fk-event_program_translation-event_program_id',
            '{{%event_program_translation}}',
            'event_program_id',
            '{{%event_program}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_program_translation-language',
            '{{%event_program_translation}}',
            'language'
        );

        $this->addForeignKey(
            'fk-event_program-location_id',
            '{{%event_program}}',
            'location_id',
            '{{%locations}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-event_program_translation-event_program_id', '{{%event_program_translation}}');
        $this->dropForeignKey('fk-event_program-location_id', '{{%event_program}}');
        $this->dropIndex('idx-event_program_translation-language', '{{%event_program_translation}}');
        $this->dropTable('{{%event_program_translation}}');
        $this->dropTable('{{%event_program}}');
    }
}
