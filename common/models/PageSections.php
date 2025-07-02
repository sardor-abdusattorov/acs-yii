<?php

namespace common\models;

use common\components\StaticFunctions;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "page_sections".
 *
 * @property int $id
 * @property int $page_id
 * @property string|null $image
 * @property int|null $sort
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property GalleryItems[] $galleryItems
 * @property Pages $page
 * @property PageSectionTranslations[] $pageSectionTranslations
 */
class PageSections extends \yii\db\ActiveRecord
{

    public $galleryImages;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'default', 'value' => null],
            [['sort'], 'default', 'value' => 0],
            [['page_id', 'name'], 'required'],
            [['page_id', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'subtitle', 'content'],
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
            'page_id' => 'Страница',
            'image' => 'Изображение',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[GalleryItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryItems()
    {
        return $this->hasMany(GalleryItems::class, ['section_id' => 'id']);
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::class, ['id' => 'page_id']);
    }

    /**
     * Gets query for [[PageSectionTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(PageSectionTranslations::class, ['section_id' => 'id']);
    }
    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->section_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

    public function getImagePreview()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'page-sections', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getImageConfig()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'page-sections', $this->id);

        return [[
            'key' => 'image_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'image',
            'downloadUrl' => $filePath,
            'url' => Url::to(['/page-sections/delete-image', 'id' => $this->id]),
        ]];
    }

    public function getGalleryPreview(){
        $images = GalleryItems::find()->where(['section_id'=>$this->id])->all();

        $result = [];

        foreach ($images as $image){
            $result[] = StaticFunctions::getImage($image->image, 'page-sections', $this->id);
        }
        return $result;
    }
    public function getGalleryConfig()
    {
        $images = GalleryItems::find()->where(['section_id' => $this->id])->all();
        $result = [];

        foreach ($images as $image) {
            $image_name = StaticFunctions::getImage($image->image, 'page-sections', $this->id);
            $result[] = [
                'key' => $image->id,
                'caption' => basename($image->image),
                'type' => 'image',
                'downloadUrl' => $image_name,
                'url' => Url::to(['/page-sections/delete-gallery-image']),
            ];
        }

        return $result;
    }

    public static function getSection(string $sectionName, string $pageName)
    {
        return self::find()
            ->joinWith('page')
            ->where([
                'page_sections.name' => $sectionName,
                'pages.name' => $pageName,
            ])
            ->with('translations', 'galleryItems')
            ->one();
    }

}
