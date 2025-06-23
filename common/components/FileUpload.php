<?php

namespace common\components;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileUpload
{
    public static function uploadFile(UploadedFile $file, string $modelType, int $modelId)
    {
        if (self::validateFile($file)) {
            $folder = self::getFolder($modelType, $modelId);
            if (!is_dir($folder)) {
                FileHelper::createDirectory($folder);
            }
            return self::saveFile($file, $folder);
        }
        return false;
    }

    public static function getFolder(string $modelType, int $modelId)
    {
        return Yii::getAlias('@frontend/web/uploads/files/' . $modelType . '/' . $modelId . '/');
    }

    public static function generateFilename(UploadedFile $file)
    {
        $shortHash = substr(md5($file->baseName . time() . rand(1, 100000)), 0, 8);
        return $file->baseName . '_' . $shortHash . '.' . $file->extension;
    }


    public static function fileExists(string $file)
    {
        return file_exists($file);
    }

    public static function saveFile(UploadedFile $file, string $folder)
    {
        $filename = self::generateFilename($file);
        $file->saveAs($folder . $filename);
        return $filename;
    }

    public static function getFile(string $filename, string $modelType, int $modelId)
    {
        $filePath = self::getFolder($modelType, $modelId) . $filename;

        if (is_file($filePath)) {
            return Yii::$app->params['frontend'] . "/uploads/files/{$modelType}/{$modelId}/{$filename}";
        }
        return false;
    }

    public static function deleteFile(string $filename, string $modelType, int $modelId)
    {
        $filePath = self::getFolder($modelType, $modelId) . $filename;
        if (self::fileExists($filePath)) {
            unlink($filePath);
        }
        $folder = self::getFolder($modelType, $modelId);

        if (is_dir($folder) && count(scandir($folder)) == 2) {
            rmdir($folder);
        }
    }

    private static function validateFile(UploadedFile $file): bool
    {
        $allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'xml', 'xls', 'xlsx', 'mp4', 'avi', 'mov', 'zip', 'rar', '7z'];
        return $file->size <= 1024 * 1024 * 50 && in_array(strtolower($file->extension), $allowedExtensions);
    }
}