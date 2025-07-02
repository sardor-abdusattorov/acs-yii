<?php

namespace common\models;

use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $name Служебное имя страницы
 * @property string $slug
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property PageSections[] $pageSections
 * @property PageTranslations[] $pageTranslations
 */
class Pages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['meta_title', 'title', 'meta_description'],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Слаг',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[PageSections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageSections()
    {
        return $this->hasMany(PageSections::class, ['page_id' => 'id']);
    }

    /**
     * Gets query for [[PageTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(PageTranslations::class, ['page_id' => 'id']);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->page_id = $this->id;

            foreach ($data as $attribute => $translation) {
                $translationModel->$attribute = $translation;
            }
        }
    }

}
