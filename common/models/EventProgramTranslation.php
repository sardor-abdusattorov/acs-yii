<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "event_program_translation".
 *
 * @property int $id
 * @property int $event_program_id
 * @property string $language
 * @property string|null $title Заголовок события
 * @property string|null $description Описание события
 *
 * @property EventProgram $eventProgram
 */
class EventProgramTranslation extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_program_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'default', 'value' => null],
            [['event_program_id', 'language'], 'required'],
            [['event_program_id'], 'integer'],
            [['description'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['event_program_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProgram::class, 'targetAttribute' => ['event_program_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_program_id' => 'Event Program ID',
            'language' => 'Language',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[EventProgram]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventProgram()
    {
        return $this->hasOne(EventProgram::class, ['id' => 'event_program_id']);
    }

}
