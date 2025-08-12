<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%columns_to_user}}`.
 */
class m250527_050912_create_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'full_name', $this->string(255)->after('username')->notNull());
        $this->addColumn('{{%user}}', 'avatar', $this->string()->after('full_name')->defaultValue(null));
        $this->addColumn('{{%user}}', 'department_id', $this->integer()->after('avatar')->null());
        $this->addColumn('{{%user}}', 'position_id', $this->integer()->null()->comment('Должность'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'full_name');
        $this->dropColumn('{{%user}}', 'avatar');
    }
}
