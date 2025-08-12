<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m250603_130340_create_settings_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'value' => $this->text()->null(),
            'image' => $this->string(255)->null(),
            'is_translatable' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%setting_translations}}', [
            'id' => $this->primaryKey(),
            'setting_id' => $this->integer()->notNull(),
            'language' => $this->string(10)->notNull(),
            'value' => $this->text()->null(),
        ]);

        $this->addForeignKey(
            'fk-setting_translations-setting_id',
            '{{%setting_translations}}',
            'setting_id',
            '{{%settings}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-setting_translations-setting_id-language',
            '{{%setting_translations}}',
            ['setting_id', 'language'],
            true
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-setting_translations-setting_id', '{{%setting_translations}}');
        $this->dropTable('{{%setting_translations}}');
        $this->dropTable('{{%settings}}');
    }
}
