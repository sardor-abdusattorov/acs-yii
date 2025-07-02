<?php

namespace common\models;

use common\components\StaticFunctions;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property int|null $status Статус
 * @property int $order_by Сортировка
 * @property string|null $image
 * @property string|null $created_at Дата создания
 * @property string|null $updated_at Дата обновления
 * @property string $name Название
 *
 * @property LocationImages[] $locationImages
 * @property LocationTranslation[] $locationTranslations
 */
class Locations extends \yii\db\ActiveRecord
{
    public $galleryImages;

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
        return 'locations';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['order_by'], 'default', 'value' => 0],
            [['status', 'order_by'], 'integer'],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['name'], 'required'],
            [['image'], 'string', 'max' => 255],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Только латинские буквы, цифры, дефисы или нижние подчеркивания. Пробелы недопустимы.'],
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
            'name' => 'Название',
            'image' => 'Изображение',
            'order_by' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[LocationImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocationImages()
    {
        return $this->hasMany(LocationImages::class, ['location_id' => 'id']);
    }

    /**
     * Gets query for [[LocationTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(LocationTranslation::class, ['location_id' => 'id']);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->location_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

    public function getGalleryPreview(){
        $images = LocationImages::find()->where(['location_id'=>$this->id])->all();

        $result = [];

        foreach ($images as $image){
            $result[] = StaticFunctions::getImage($image->image, 'locations', $this->id);
        }
        return $result;
    }
    public function getGalleryConfig()
    {
        $images = LocationImages::find()->where(['location_id' => $this->id])->all();
        $result = [];

        foreach ($images as $image) {
            $image_name = StaticFunctions::getImage($image->image, 'locations', $this->id);
            $result[] = [
                'key' => $image->id,
                'caption' => basename($image->image),
                'type' => 'image',
                'downloadUrl' => $image_name,
                'url' => Url::to(['/locations/delete-gallery-image']),
            ];
        }

        return $result;
    }

    public function getImagePreview()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'locations', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getImageConfig()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'locations', $this->id);

        return [[
            'key' => 'image_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'image',
            'downloadUrl' => $filePath,
            'url' => Url::to(['/locations/delete-image', 'id' => $this->id]),
        ]];
    }

    public static function getDropdownList($language = null)
    {
        $language = $language ?? Yii::$app->language;

        return self::find()
            ->joinWith('translations t')
            ->where(['t.language' => $language])
            ->select(['title' => 't.title', 'id' => 'locations.id'])
            ->indexBy('id')
            ->column();
    }


}
