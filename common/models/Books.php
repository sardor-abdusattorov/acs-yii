<?php

namespace common\models;

use common\components\FileUpload;
use common\components\StaticFunctions;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $file
 * @property string|null $link
 * @property int $status Статус
 * @property int $order_by Сортировка
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BooksTranslations[] $booksTranslations
 */
class Books extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['author', 'name', 'description'],
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
            [['image', 'file', 'link'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['order_by'], 'default', 'value' => 0],
            [['status', 'order_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'file', 'link'], 'string', 'max' => 255],
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
            'file' => 'Файл',
            'link' => 'Ссылка',
            'status' => 'Статус',
            'order_by' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[BooksTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(BooksTranslations::class, ['book_id' => 'id']);
    }

    public function getImagePreview()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'books', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getImageConfig()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'books', $this->id);

        return [[
            'key' => 'image_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'image',
            'downloadUrl' => $filePath,
            'url' => Url::to(['/books/delete-image', 'id' => $this->id]),
        ]];
    }

    public function getFilePreview()
    {
        if (!$this->image) return [];

        $filePath = FileUpload::getFile($this->file, 'books', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getFileConfig()
    {
        if (!$this->file) return [];

        $filePath = FileUpload::getFile($this->file, 'books', $this->id);

        return [[
            'key' => 'file_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'file',
            'downloadUrl' => $filePath,
            'url' => Url::to(['/books/delete-file', 'id' => $this->id]),
        ]];
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->book_id = $this->id;

            foreach ($data as $attribute => $value) {
                $translationModel->$attribute = empty($value) ? null : $value;
            }

            $translationModel->save(false);
        }
    }

}
