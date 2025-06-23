<?php


namespace common\components;

use common\models\Menu;
use common\models\Organisations;
use Yii;
use yii\base\ErrorException;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;

class StaticFunctions
{
    /**
     * Uploads an image file.
     *
     * @param UploadedFile $file The file to upload
     * @param string $modelType The type of the model (e.g., 'user')
     * @param int $modelId The ID of the model
     * @return string|bool The new filename on success, false on failure
     */
    public static function uploadFile(UploadedFile $file, string $modelType, int $modelId)
    {
        if ($file instanceof UploadedFile) {
            if (!in_array($file->extension, ['png', 'jpg', 'jpeg', 'svg']) || $file->size > 1024 * 1024 * 3) {
                return false;
            }
            $folder = self::getFolder($modelType, $modelId);
            if (!is_dir($folder)) {
                FileHelper::createDirectory($folder);
            }
            return self::saveImage($file, $folder);
        }
        return false;
    }

    /**
     * Gets the folder path for the uploaded files.
     *
     * @param string $modelType The type of the model (e.g., 'user')
     * @param int $modelId The ID of the model
     * @return string The folder path
     */
    public static function getFolder(string $modelType, int $modelId)
    {
        return Yii::getAlias('@frontend/web/uploads/images/' . $modelType . '/' . $modelId . '/');
    }

    /**
     * Generates a unique filename for the image.
     *
     * @param UploadedFile $file The file to generate the filename for
     * @return string The generated filename
     */
    public static function generateFilename(UploadedFile $file)
    {
        return "photo_" . md5($file->baseName . time() . rand(1, 100000)) . '.' . $file->extension;
    }

    /**
     * Checks if the file exists.
     *
     * @param string $file The file path
     * @return bool Whether the file exists
     */
    public static function fileExists($file)
    {
        return file_exists($file);
    }

    /**
     * Saves the uploaded image file.
     *
     * @param UploadedFile $file The file to save
     * @param string $folder The folder path where the file will be saved
     * @return string The saved filename
     */
    public static function saveImage($file, $folder)
    {
        $filename = self::generateFilename($file);
        $file->saveAs($folder . $filename);
        return $filename;
    }

    public static function getImage($imageName, $modelType, $modelId)
    {
        $file = Yii::getAlias("@frontend") . "/web/uploads/images/{$modelType}/{$modelId}/{$imageName}";
        if (is_file($file)) {
            return Yii::$app->params['frontend'] . "/uploads/images/{$modelType}/{$modelId}/{$imageName}";
        }
        return Yii::$app->params['frontend'] . "/images/no_image.png";
    }

    /**
     * @throws ErrorException
     */
    public static function deleteImage($imageName, $modelType, $modelId)
    {
        $folder = self::getFolder($modelType, $modelId);
        $file = $folder . $imageName;
        $thumbFolder = $folder . 'thumbs/';
        $thumb = $thumbFolder . $imageName;

        if (is_file($file)) {
            unlink($file);
        }

        if (is_file($thumb)) {
            unlink($thumb);
        }

        if (is_dir($thumbFolder)) {
            $files = array_diff(scandir($thumbFolder), ['.', '..']);
            if (empty($files)) {
                FileHelper::removeDirectory($thumbFolder);
            }
        }

        if (is_dir($folder)) {
            $files = array_diff(scandir($folder), ['.', '..']);
            if (empty($files)) {
                FileHelper::removeDirectory($folder);
            }
        }
    }

    /**
     * Saves a thumbnail version of an uploaded image.
     *
     * @param UploadedFile $file The file to create a thumbnail for
     * @param string $folder The folder where the thumbnail will be saved
     * @param int $width Thumbnail width
     * @param int $height Thumbnail height
     * @return string The thumbnail filename
     */
    public static function saveThumbnail(string $sourcePath, string $modelType, int $modelId, string $filename, int $width = 300, int $height = 300)
    {
        $thumbFolder = self::getFolder($modelType, $modelId) . 'thumbs/';
        if (!is_dir($thumbFolder)) {
            FileHelper::createDirectory($thumbFolder);
        }

        $thumbPath = $thumbFolder . $filename;

        Image::thumbnail($sourcePath, $width, $height)
            ->save($thumbPath, ['quality' => 85]);

        return $filename;
    }

    public static function getThumbnail($imageName, $modelType, $modelId)
    {
        $file = Yii::getAlias("@frontend") . "/web/uploads/images/{$modelType}/{$modelId}/thumbs/{$imageName}";
        if (is_file($file)) {
            return Yii::$app->params['frontend'] . "/uploads/images/{$modelType}/{$modelId}/thumbs/{$imageName}";
        }
        return Yii::$app->params['frontend'] . "/images/no_image.png";
    }

    public static function getTableCounts($tableName)
    {
        $db = Yii::$app->db;
        $tables = $db->schema->getTableNames();
        if (!in_array($tableName, $tables)) {
            return 0;
        }
        return (new Query())
            ->from($tableName)
            ->count();
    }

    public static function isActive(string $route): string
    {
        $currentRoute = Yii::$app->controller->route;
        return strpos($currentRoute, $route) === 0 ? 'active' : '';
    }

    public static function isGroupActive(array $controllers): string
    {
        return in_array(Yii::$app->controller->id, $controllers) ? 'active' : '';
    }

    public static function renderMenu(int $position = 1, ?int $parentId = null): string
    {
        $html = '';

        $menus = Menu::find()
            ->alias('m')
            ->where([
                'm.parent_id' => $parentId,
                'm.position' => $position,
                'm.status' => 1,
            ])
            ->with('translations')
            ->orderBy(['m.order_by' => SORT_ASC])
            ->all();

        foreach ($menus as $menu) {
            $title = Html::encode($menu->translation->title ?? '—');
            $url = Html::encode(Url::to(["/$menu->link"]));
            $isActive = Url::to(["/$menu->link"]) === Yii::$app->request->url;
            $activeClass = $isActive ? ' active' : '';

            if ($menu->link === '/organisations') {
                $organisations = Organisations::find()
                    ->where(['status' => 1])
                    ->orderBy(['id' => SORT_ASC])
                    ->all();

                if (!empty($organisations)) {
                    $html .= '<li class="header__nav-item header__nav-item--dropdown">';
                    $html .= '<a href="' . $url . '" class="header__nav-link' . $activeClass . '">' . $title . '</a>';
                    $html .= '<ul class="header__nav-dropdown">';

                    foreach ($organisations as $org) {
                        $orgTitle = Html::encode($org->translate(Yii::$app->language)->title ?? '—');
                        $orgUrl = Html::encode(Url::to(['/organisations/' . $org->slug]));
                        $html .= '<li class="header__nav-dropdown-item">';
                        $html .= '<a href="' . $orgUrl . '" class="header__nav-dropdown-link">' . $orgTitle . '</a>';
                        $html .= '</li>';
                    }

                    $html .= '</ul>';
                    $html .= '</li>';
                } else {
                    $html .= '<li class="header__nav-item">';
                    $html .= '<a href="' . $url . '" class="header__nav-link' . $activeClass . '">' . $title . '</a>';
                    $html .= '</li>';
                }

                continue;
            }

            $children = Menu::find()
                ->where(['parent_id' => $menu->id, 'status' => 1])
                ->with('translations')
                ->orderBy(['order_by' => SORT_ASC])
                ->all();

            if (!empty($children)) {
                $html .= '<li class="header__nav-item header__nav-item--dropdown">';
                $html .= '<a href="' . $url . '" class="header__nav-link' . $activeClass . '">' . $title . '</a>';
                $html .= '<ul class="header__nav-dropdown">';

                foreach ($children as $child) {
                    $childTitle = Html::encode($child->translation->title ?? '—');
                    $childUrl = Html::encode(Url::to(["/$child->link"]));
                    $html .= '<li class="header__nav-dropdown-item">';
                    $html .= '<a href="' . $childUrl . '" class="header__nav-dropdown-link">' . $childTitle . '</a>';
                    $html .= '</li>';
                }

                $html .= '</ul>';
                $html .= '</li>';
            } else {
                $html .= '<li class="header__nav-item">';
                $html .= '<a href="' . $url . '" class="header__nav-link' . $activeClass . '">' . $title . '</a>';
                $html .= '</li>';
            }
        }

        return $html;
    }

    public static function renderMenuForHamburger(int $position = 1, ?int $parentId = null): string
    {
        $html = '';

        $menus = Menu::find()
            ->alias('m')
            ->where([
                'm.parent_id' => $parentId,
                'm.position' => $position,
                'm.status' => 1,
            ])
            ->with('translations')
            ->orderBy(['m.order_by' => SORT_ASC])
            ->all();

        foreach ($menus as $menu) {
            $title = Html::encode($menu->translation->title ?? '—');
            $url = Html::encode(Url::to(["/$menu->link"]));
            $isActive = Url::to(["/$menu->link"]) === Yii::$app->request->url;
            $activeClass = $isActive ? ' active' : '';

            if ($menu->link === '/organisations') {
                $organisations = Organisations::find()
                    ->where(['status' => 1])
                    ->orderBy(['id' => SORT_ASC])
                    ->all();

                if (!empty($organisations)) {
                    $html .= '<li class="has-dropdown">';
                    $html .= '<a href="' . $url . '" class="hamburger__menu-link' . $activeClass . '">' . $title . '</a>';
                    $html .= '<ul class="hamburger__submenu">';

                    foreach ($organisations as $org) {
                        $orgTitle = Html::encode($org->translate(Yii::$app->language)->title ?? '—');
                        $orgUrl = Html::encode(Url::to(['/organisations/' . $org->slug]));
                        $html .= '<li><a href="' . $orgUrl . '" class="hamburger__menu-sublink">' . $orgTitle . '</a></li>';
                    }

                    $html .= '</ul>';
                    $html .= '</li>';
                } else {
                    $html .= '<li><a href="' . $url . '" class="hamburger__menu-link' . $activeClass . '">' . $title . '</a></li>';
                }

                continue;
            }

            $children = Menu::find()
                ->where(['parent_id' => $menu->id, 'status' => 1])
                ->with('translations')
                ->orderBy(['order_by' => SORT_ASC])
                ->all();

            if (!empty($children)) {
                $html .= '<li class="has-dropdown">';
                $html .= '<a href="' . $url . '" class="hamburger__menu-link' . $activeClass . '">' . $title . '</a>';
                $html .= '<ul class="hamburger__submenu">';

                foreach ($children as $child) {
                    $childTitle = Html::encode($child->translation->title ?? '—');
                    $childUrl = Html::encode(Url::to(["/$child->link"]));
                    $html .= '<li><a href="' . $childUrl . '" class="hamburger__menu-sublink">' . $childTitle . '</a></li>';
                }

                $html .= '</ul>';
                $html .= '</li>';
            } else {
                $html .= '<li><a href="' . $url . '" class="hamburger__menu-link' . $activeClass . '">' . $title . '</a></li>';
            }
        }

        return $html;
    }
    
    public static function saveBase64Image($base64, $modelType, $modelId)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            return false;
        }

        $data = substr($base64, strpos($base64, ',') + 1);
        $data = base64_decode($data);
        if ($data === false) {
            return false;
        }

        $folder = self::getFolder($modelType, $modelId);
        if (!is_dir($folder)) {
            FileHelper::createDirectory($folder);
        }

        $filename = 'sign_' . md5(time() . rand()) . '.png';
        $path = $folder . $filename;

        if (file_put_contents($path, $data)) {
            return $filename;
        }

        return false;
    }

}
