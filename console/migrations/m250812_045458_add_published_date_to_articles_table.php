<?php

use yii\db\Migration;

class m250812_045458_add_published_date_to_articles_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%articles}}',
            'published_date',
            $this->dateTime()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->comment('Дата публикации')
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%articles}}', 'published_date');
    }
}
