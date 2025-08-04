<?php

namespace common\models;

use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "program_sessions".
 *
 * @property int $id
 * @property int $date_id
 * @property int|null $sort
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class ProgramSessions extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program_sessions';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'content'],
            ],
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }


    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->session_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

    public function getTranslations()
    {
        return $this->hasMany(ProgramSessionsTranslation::class, ['session_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => null],
            [['date_id'], 'required'],
            [['date_id', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_id' => 'Дата',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getDate()
    {
        return $this->hasOne(ProgramDate::class, ['id' => 'date_id']);
    }


}
