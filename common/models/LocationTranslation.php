<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "location_translation".
 *
 * @property int $id
 * @property int $location_id
 * @property string $language
 * @property string $title Заголовок
 * @property string|null $content Контент
 *
 * @property Locations $location
 */
class LocationTranslation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'default', 'value' => null],
            [['location_id', 'language', 'title'], 'required'],
            [['location_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locations::class, 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'ID локации',
            'name' => 'Название',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'content' => 'Контент',
        ];
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Locations::class, ['id' => 'location_id']);
    }

}
