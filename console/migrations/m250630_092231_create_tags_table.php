<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}` and `{{%tag_translation}}`.
 */
class m250630_092231_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
            'order_by' => $this->integer()->notNull()->defaultValue(0)->comment('Сортировка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%tag_translation}}', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull()->comment('Название тега'),
        ]);

        // Внешний ключ
        $this->addForeignKey(
            'fk-tag_translation-tag_id',
            '{{%tag_translation}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Индекс для языка
        $this->createIndex(
            'idx-tag_translation-language',
            '{{%tag_translation}}',
            'language'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-tag_translation-tag_id', '{{%tag_translation}}');
        $this->dropIndex('idx-tag_translation-language', '{{%tag_translation}}');
        $this->dropTable('{{%tag_translation}}');
        $this->dropTable('{{%tags}}');
    }
}
