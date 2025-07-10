<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag_translation".
 *
 * @property int $id
 * @property int $tag_id
 * @property string $language
 * @property string $title Название тега
 *
 * @property Tags $tag
 */
class TagTranslation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'language', 'title'], 'required'],
            [['tag_id'], 'integer'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'language' => 'Language',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

}
