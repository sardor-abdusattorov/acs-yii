<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "registration".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string|null $state
 * @property string|null $postal_code
 * @property string|null $sources
 * @property string|null $attendance_days
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Registration extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state', 'postal_code', 'sources', 'attendance_days'], 'default', 'value' => null],
            [['first_name', 'last_name', 'email', 'phone', 'address', 'city'], 'required'],
            [['sources', 'attendance_days', 'created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'postal_code'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State / Province'),
            'postal_code' => Yii::t('app', 'Postal / ZIP'),
            'sources' => Yii::t('app', 'How did you hear about the Summit?'),
            'attendance_days' => Yii::t('app', 'How many will attend? (multiple choice allowed)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

}
