<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Pages;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $this->setDefaultSeo();
        return parent::beforeAction($action);
    }

    protected function setDefaultSeo(): void
    {
        $page = Pages::find()
            ->where(['name' => 'home'])
            ->with('translations')
            ->one();

        if ($page) {
            $t = $page->translate();
            $language = Yii::$app->language;

            if (empty($this->view->title)) {
                $this->view->title = $t->meta_title ?: $t->title;
            }

            if (!empty($t->meta_description)) {
                Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $t->meta_description,
                ], 'description');
            }

            Yii::$app->view->registerMetaTag([
                'property' => 'og:title',
                'content' => $t->meta_title ?: $t->title,
            ], 'og:title');

            if (!empty($t->meta_description)) {
                Yii::$app->view->registerMetaTag([
                    'property' => 'og:description',
                    'content' => $t->meta_description,
                ], 'og:description');
            }

            switch ($language) {
                case 'ru':
                    $logo = '/images/logos/logo_home_new_ru.png';
                    break;
                case 'uz':
                    $logo = '/images/logo_home/logo_home_new_uz.png';
                    break;
                case 'ka':
                    $logo = '/images/logo_home/logo_home_new_ka.png';
                    break;
                case 'en':
                default:
                    $logo = '/images/logo_home/logo_home_new_en.png';
                    break;
            }

            Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => Yii::$app->request->hostInfo . $logo,
            ], 'og:image');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:url',
                'content' => Url::to(['/', 'language' => Yii::$app->language], true),
            ], 'og:url');


        }
    }

}
