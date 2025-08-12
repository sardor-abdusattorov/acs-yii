<?php

namespace common\components;

use common\models\Settings;
use Yii;

class Helpers
{
    public static function setting($key, $default = null)
    {
        $setting = Settings::findOne(['name' => $key]);
        return $setting ? $setting->val : $default;
    }

    /**
     * Форматировать размер файла
     */
    public static function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size /= $step;
            $i++;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Сгенерировать slug из строки
     */
    public static function slugFormat($string)
    {
        $string = preg_replace('/\s+/u', '-', trim($string));
        return strtolower($string);
    }

    /**
     * Получить текущую дату в формате
     */
    public static function dateToday()
    {
        return Yii::$app->formatter->asDate(time(), 'php:l, d F Y');
    }

    /**
     * Кодирование ID
     */
    public static function encodeId($id)
    {
        return base64_encode($id);
    }

    /**
     * Декодирование ID
     */
    public static function decodeId($hashid)
    {
        return base64_decode($hashid);
    }
}