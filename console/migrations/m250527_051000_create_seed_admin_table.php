<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Handles the creation of table `{{%seed_admin}}`.
 */
class m250527_051000_create_seed_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}', [
            'name' => 'superadmin',
            'type' => 1,
            'description' => 'Super admin role',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%auth_item}}', [
            'name' => '/*',
            'type' => 2,
            'description' => 'Full access to all actions',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'full_name' => 'Admin',
            'avatar' => '',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'password_reset_token' => null,
            'email' => 'admin@example.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
            'verification_token' => null
        ]);

        $userId = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->scalar();

        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'superadmin',
            'user_id' => $userId,
            'created_at' => time()
        ]);

        $this->insert('{{%auth_item_child}}', [
            'parent' => 'superadmin',
            'child' => '/*',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%auth_item_child}}', ['parent' => 'superadmin', 'child' => '/*']);
        $this->delete('{{%auth_item}}', ['name' => '/*']);
        $this->delete('{{%auth_item}}', ['name' => 'superadmin']);
        $this->delete('{{%auth_assignment}}', ['item_name' => 'superadmin']);
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}
