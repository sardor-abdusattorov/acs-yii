<?php

namespace common\models;

use common\components\StaticFunctions;
use creocoder\translateable\TranslateableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property string|null $image
 * @property int $is_translatable
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SettingTranslations[] $settingTranslations
 */
class Settings extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['value'],
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
            [['value', 'image'], 'default', 'value' => null],
            [['is_translatable'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['value'], 'string'],
            [['is_translatable'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['name'], 'unique'],

            ['value', 'required', 'when' => function ($model) {
                return !$model->is_translatable;
            }, 'whenClient' => "function (attribute, value) {
            return !$('#is-translatable-toggle').is(':checked');
        }"],

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
            'value' => 'Значение',
            'image' => 'Изображение',
            'is_translatable' => 'Многоязычный',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[SettingTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(SettingTranslations::class, ['setting_id' => 'id']);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->setting_id = $this->id;

            foreach ($data as $attribute => $translation) {
                $translationModel->$attribute = $translation;
            }
        }
    }

    public function getImagePreview()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'settings', $this->id);
        return $filePath ? [$filePath] : [];
    }

    public function getImageConfig()
    {
        if (!$this->image) return [];

        $filePath = StaticFunctions::getImage($this->image, 'settings', $this->id);

        return [[
            'key' => 'image_' . $this->id,
            'caption' => basename($this->image),
            'type' => 'image',
            'downloadUrl' => $filePath,
            'url' => Url::to(['settings/delete-image', 'id' => $this->id]),
        ]];
    }

    public static function getSettings(array $names): array
    {
        return self::find()
            ->where(['name' => $names])
            ->with('translations')
            ->indexBy('name')
            ->all();
    }

    public static function getValues(array $names): array
    {
        $settings = self::find()
            ->where(['name' => $names])
            ->with('translations')
            ->all();

        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->name] = $setting->is_translatable
                ? $setting->getTranslation()->value ?? null
                : $setting->value;
        }

        return $result;
    }



}
