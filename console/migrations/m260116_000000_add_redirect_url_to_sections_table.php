<?php

use yii\db\Migration;

/**
 * Handles adding redirect_url to table `{{%sections}}`.
 */
class m260116_000000_add_redirect_url_to_sections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sections}}', 'redirect_url', $this->string()->null()->after('is_opened'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sections}}', 'redirect_url');
    }
}
