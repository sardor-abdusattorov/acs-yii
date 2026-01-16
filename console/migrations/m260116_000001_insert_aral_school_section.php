<?php

use yii\db\Migration;

/**
 * Handles inserting aral_school section into table `{{%sections}}`.
 */
class m260116_000001_insert_aral_school_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%sections}}', [
            'name' => 'Aral school',
            'is_opened' => 0,
            'redirect_url' => 'https://www.aralschool.uz/en',
            'status' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%sections}}', ['name' => 'aral_school']);
    }
}
