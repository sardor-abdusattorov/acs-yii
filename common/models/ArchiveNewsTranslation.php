<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "archive_news_translation".
 *
 * @property int $id
 * @property int $news_id
 * @property string $language
 * @property string $title
 * @property string|null $description
 */
class ArchiveNewsTranslation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archive_news_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['news_id', 'language', 'title'], 'required'],
            [['news_id'], 'integer'],
            [['description'], 'string'],
            [['language'], 'string', 'max' => 8],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'ID новости',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'description' => 'Описание',
        ];
    }

}
