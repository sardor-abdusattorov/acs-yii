<?php

namespace common\models;

use common\components\StaticFunctions;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $slug
 * @property int $order_by Сортировка
 * @property int $status Статус
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $published_date Дата публикации
 *
 * @property ArticlesTranslations[] $articlesTranslations
 */
class Articles extends \yii\db\ActiveRecord
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
        return 'articles';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'description', 'content'],
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
            [['image', 'slug'], 'default', 'value' => null],
            [['order_by'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['order_by', 'status'], 'integer'],
            [['created_at', 'updated_at','published_date'], 'safe'],
            [['image', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'slug' => 'Слаг',
            'order_by' => 'Порядок',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'published_date' => 'Дата публикации',
        ];
    }


    /**
     * Gets query for [[ArticlesTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ArticlesTranslations::class, ['article_id' => 'id']);
    }


    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->article_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

    public function getImagePreview()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'articles', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getImageConfig()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'articles', $this->id);

        return [[
            'key' => 'image_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'image',
            'downloadUrl' => $filePath,
            'url' => Url::to(['/articles/delete-image', 'id' => $this->id]),
        ]];
    }

    public static function slugify($string): string
    {
        return Inflector::slug($string);
    }

}
