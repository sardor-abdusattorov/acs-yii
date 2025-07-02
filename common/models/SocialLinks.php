<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "social_links".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property string $link
 * @property int|null $order_by
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SocialLinks extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_links';
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
            [['order_by'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['name', 'class', 'link'], 'required'],
            [['order_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'class', 'link'], 'string', 'max' => 255],
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
            'class' => 'Иконка',
            'link' => 'Ссылка',
            'order_by' => 'Порядок сортировки',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

}
