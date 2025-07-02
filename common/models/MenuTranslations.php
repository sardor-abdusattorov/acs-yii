<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_translations".
 *
 * @property int $id
 * @property int $menu_id
 * @property string $language
 * @property string $title
 *
 * @property Menu $menu
 */
class MenuTranslations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'language', 'title'], 'required'],
            [['menu_id'], 'integer'],
            [['language'], 'string', 'max' => 5],
            [['title'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'ID меню',
            'language' => 'Язык',
            'title' => 'Заголовок',
        ];
    }


    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }

}
