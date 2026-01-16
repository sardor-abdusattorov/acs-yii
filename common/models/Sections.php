<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "sections".
 *
 * @property int $id
 * @property string $name
 * @property int $is_opened
 * @property string|null $redirect_url
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Sections extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sections';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_opened'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['name'], 'required'],
            [['is_opened', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'redirect_url'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['redirect_url'], 'url'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->is_opened == 1) {
                self::updateAll(['is_opened' => 0], ['<>', 'id', $this->id]);
            } else {
                $otherOpenedExists = self::find()
                    ->where(['is_opened' => 1])
                    ->andWhere(['<>', 'id', $this->id])
                    ->exists();

                if (!$otherOpenedExists) {
                    $this->addError('is_opened', 'Должна быть хотя бы одна открытая секция.');
                    return false;
                }
            }

            if ($this->status == 0) {
                $otherActiveExists = self::find()
                    ->where(['status' => 1])
                    ->andWhere(['<>', 'id', $this->id])
                    ->exists();

                if (!$otherActiveExists) {
                    $this->addError('status', 'Должна быть хотя бы одна активная секция.');
                    return false;
                }
            }
            // *****************************************

            return true;
        }
        return false;
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'is_opened' => 'Открыт',
            'redirect_url' => 'URL редиректа',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

}
