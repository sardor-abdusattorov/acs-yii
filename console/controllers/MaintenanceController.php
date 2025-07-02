<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

class MaintenanceController extends Controller
{
    /**
     * Полная очистка runtime, assets и application cache, без удаления папок и .gitignore.
     */
    public function actionClearCache()
    {
        $paths = [
            Yii::getAlias('@runtime'),
            Yii::getAlias('@console/runtime'),
            Yii::getAlias('@frontend/web/assets'),
            Yii::getAlias('@backend/web/assets'),
        ];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                echo "Очистка содержимого: $path\n";
                $this->clearDirectory($path);
            }
        }

        echo "Очистка application cache...\n";
        Yii::$app->cache->flush();

        echo "✅ Кеш, runtime и assets успешно очищены.\n";
    }

    /**
     * Удаляет все файлы и подпапки внутри директории, кроме .gitignore.
     */
    private function clearDirectory($path)
    {
        $items = scandir($path);
        foreach ($items as $item) {
            if (in_array($item, ['.', '..', '.gitignore'])) {
                continue;
            }

            $fullPath = $path . DIRECTORY_SEPARATOR . $item;

            if (is_dir($fullPath)) {
                FileHelper::removeDirectory($fullPath);
            } else {
                @unlink($fullPath);
            }
        }
    }
}
