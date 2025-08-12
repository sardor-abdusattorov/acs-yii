<?php

namespace common\models;

use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "event_program".
 *
 * @property int $id
 * @property string $day Дата проведения (день)
 * @property string $start_time Время начала
 * @property int|null $tag_id ID тега (из справочника tags)
 * @property string $end_time Время окончания
 * @property int|null $location_id ID локации (из справочника locations)
 * @property string|null $bg_color Фон для блока (цвет)
 * @property int $status Статус
 * @property int $order_by Сортировка
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property EventProgramTranslation[] $eventProgramTranslations
 * @property Locations $location
 */
class EventProgram extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVED = -1;

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_ARCHIVED => 'Архив',
        ];

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_program';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'description'],
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'location_id', 'bg_color'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['order_by'], 'default', 'value' => 0],
            [['day', 'start_time', 'end_time'], 'required'],
            [['day', 'start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['tag_id', 'location_id', 'status', 'order_by'], 'integer'],
            [['bg_color'], 'string', 'max' => 50],
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
            'day' => 'Дата',
            'start_time' => 'Время начала',
            'tag_id' => 'Тег',
            'end_time' => 'Время окончания',
            'location_id' => 'Локация',
            'bg_color' => 'Цвет фона',
            'status' => 'Статус',
            'order_by' => 'Порядок сортировки',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[EventProgramTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(EventProgramTranslation::class, ['event_program_id' => 'id']);
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

    public function getTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->event_program_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

}
