<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "articles_translations".
 *
 * @property int $id
 * @property int $article_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string|null $content
 *
 * @property Articles $article
 */
class ArticlesTranslations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'default', 'value' => null],
            [['article_id', 'language', 'title', 'description'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title', 'description'], 'string', 'max' => 255],
            [['article_id', 'language'], 'unique', 'targetAttribute' => ['article_id', 'language']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'ID статьи',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'content' => 'Содержание',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'article_id']);
    }

}
