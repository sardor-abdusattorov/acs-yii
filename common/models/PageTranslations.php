<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_translations".
 *
 * @property int $id
 * @property int $page_id
 * @property string $language
 * @property string $title
 * @property string|null $meta_title
 * @property string|null $meta_description
 *
 * @property Pages $page
 */
class PageTranslations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_title', 'meta_description'], 'default', 'value' => null],
            [['page_id', 'language', 'title'], 'required'],
            [['page_id'], 'integer'],
            [['meta_description'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title', 'meta_title'], 'string', 'max' => 255],
            [['page_id', 'language'], 'unique', 'targetAttribute' => ['page_id', 'language']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'ID страницы',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'meta_title' => 'Мета-заголовок',
            'meta_description' => 'Мета-описание',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::class, ['id' => 'page_id']);
    }

}
