<?php

use yii\db\Migration;

class m250801_131853_create_program_sessions_table extends Migration
{
    public function safeUp()
    {
        // 1. Даты
        $this->createTable('{{%program_date}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // 2. Сессии
        $this->createTable('{{%program_sessions}}', [
            'id' => $this->primaryKey(),
            'date_id' => $this->integer()->notNull(),
            'sort' => $this->integer()->null(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // 3. Переводы сессий
        $this->createTable('{{%program_sessions_translation}}', [
            'id' => $this->primaryKey(),
            'session_id' => $this->integer()->notNull(),
            'language' => $this->string(8)->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%program_sessions_translation}}');
        $this->dropTable('{{%program_sessions}}');
        $this->dropTable('{{%program_date}}');
    }
}
