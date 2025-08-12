<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery_items".
 *
 * @property int $id
 * @property int $section_id
 * @property string $image
 * @property int|null $sort
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property PageSections $section
 */
class GalleryItems extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => 0],
            [['section_id', 'image'], 'required'],
            [['section_id', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'string', 'max' => 255],
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
            'section_id' => 'Секция',
            'image' => 'Изображение',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
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
