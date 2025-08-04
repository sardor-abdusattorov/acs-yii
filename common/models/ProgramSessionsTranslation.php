<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program_sessions_translation".
 *
 * @property int $id
 * @property int $session_id
 * @property string $language
 * @property string $title
 * @property string|null $content
 */
class ProgramSessionsTranslation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program_sessions_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'default', 'value' => null],
            [['session_id', 'language', 'title'], 'required'],
            [['session_id'], 'integer'],
            [['content'], 'string'],
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
            'session_id' => 'Сессия',
            'language' => 'Язык',
            'title' => 'Заголовок',
            'content' => 'Контент',
        ];
    }

}
