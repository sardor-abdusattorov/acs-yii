<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribers}}`.
 */
class m250627_120902_create_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribers}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%subscribers}}');
    }
}
