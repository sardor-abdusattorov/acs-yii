<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting_translations".
 *
 * @property int $id
 * @property int $setting_id
 * @property string $language
 * @property string|null $value
 *
 * @property Settings $setting
 */
class SettingTranslations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'default', 'value' => null],
            [['setting_id', 'language'], 'required'],
            [['setting_id'], 'integer'],
            [['value'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['setting_id', 'language'], 'unique', 'targetAttribute' => ['setting_id', 'language']],
            [['setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settings::class, 'targetAttribute' => ['setting_id' => 'id']],

            ['value', 'required', 'when' => function ($model) {
                return $model->setting && $model->setting->is_translatable;
            }, 'whenClient' => "function (attribute, value) {
            return $('#is-translatable-toggle').is(':checked');
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
            'setting_id' => 'ID настройки',
            'language' => 'Язык',
            'value' => 'Значение',
        ];
    }

    /**
     * Gets query for [[Setting]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Settings::class, ['id' => 'setting_id']);
    }

}
