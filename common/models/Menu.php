<?php

namespace common\models;

use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string|null $link
 * @property int|null $position
 * @property int|null $parent_id
 * @property int $order_by
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property MenuTranslations[] $menuTranslations
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title'],
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
            [['link', 'parent_id'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['status'], 'required'],
            [['order_by'], 'default', 'value' => 0],
            [['position', 'parent_id', 'order_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Ссылка',
            'position' => 'Позиция',
            'parent_id' => 'Родительское меню',
            'order_by' => 'Сортировка',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[MenuTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(MenuTranslations::class, ['menu_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent_id'])->with('translations');
    }

    public static function getGroupedParentOptions($excludeId = null): array
    {
        $positionLabels = Yii::$app->params['menu_positions'];

        $query = self::find()
            ->alias('m')
            ->joinWith(['translations t'])
            ->where(['m.parent_id' => null, 't.language' => Yii::$app->language]);

        if ($excludeId !== null) {
            $query->andWhere(['<>', 'm.id', $excludeId]);
        }

        $items = $query
            ->select(['m.id', 't.title', 'm.position'])
            ->asArray()
            ->all();

        $grouped = [];

        foreach ($items as $item) {
            $group = $positionLabels[$item['position']] ?? 'Без позиции';
            $grouped[$group][$item['id']] = $item['title'];
        }

        return $grouped;
    }
    public function getTranslation()
    {
        return $this->hasOne(MenuTranslations::class, ['menu_id' => 'id'])
            ->andWhere(['language' => Yii::$app->language]);
    }

    public function saveTranslations(array $translations): void
    {
        foreach ($translations as $language => $data) {
            $translationModel = $this->translate($language);
            $translationModel->menu_id = $this->id;

            foreach ($data as $attribute => $translation) {
                $translationModel->$attribute = $translation;
            }
        }
    }

}
