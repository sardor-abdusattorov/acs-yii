<?php

namespace common\models;

use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property int $status Статус
 * @property int $order_by Сортировка
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property TagTranslation[] $tagTranslations
 */
class Tags extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title'],
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
            [['status'], 'default', 'value' => 1],
            [['order_by'], 'default', 'value' => 0],
            [['status', 'order_by'], 'integer'],
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
            'status' => 'Статус',
            'order_by' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[TagTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(TagTranslation::class, ['tag_id' => 'id']);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->tag_id = $this->id;

            foreach ($data as $attribute => $translation) {
                $translationModel->$attribute = $translation;
            }
        }
    }

    public static function getDropdownList($language = null)
    {
        $language = $language ?? Yii::$app->language;

        return self::find()
            ->joinWith('translations t')
            ->where(['t.language' => $language])
            ->select(['title' => 't.title', 'id' => 'tags.id'])
            ->indexBy('id')
            ->column();
    }

}
