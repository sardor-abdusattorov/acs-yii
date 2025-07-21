<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_section_translations".
 *
 * @property int $id
 * @property int $section_id
 * @property string $language
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $content
 *
 * @property PageSections $section
 */
class PageSectionTranslations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_section_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'subtitle', 'content'], 'default', 'value' => null],
            [['section_id', 'language'], 'required'],
            [['section_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['section_id', 'language'], 'unique', 'targetAttribute' => ['section_id', 'language']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageSections::class, 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'ID секции',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'subtitle' => 'Подзаголовок',
            'content' => 'Контент',
        ];
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(PageSections::class, ['id' => 'section_id']);
    }

}
