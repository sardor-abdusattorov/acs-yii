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
            $currentUrl = Url::to(['/', 'language' => $language], true);
            $siteName = 'ACS'; // Можете изменить на название вашего сайта

            // Установка title
            if (empty($this->view->title)) {
                $this->view->title = $t->meta_title ?: $t->title;
            }

            // Meta Description
            if (!empty($t->meta_description)) {
                Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $t->meta_description,
                ], 'description');
            }

            // Meta Keywords (если есть в базе)
            // Yii::$app->view->registerMetaTag([
            //     'name' => 'keywords',
            //     'content' => 'ваши ключевые слова',
            // ], 'keywords');

            // Robots meta tag
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'index, follow',
            ], 'robots');

            // Canonical URL
            Yii::$app->view->registerLinkTag([
                'rel' => 'canonical',
                'href' => $currentUrl,
            ]);

            // Hreflang tags для мультиязычности
            $languages = ['en', 'ru', 'uz', 'ka'];
            foreach ($languages as $lang) {
                Yii::$app->view->registerLinkTag([
                    'rel' => 'alternate',
                    'hreflang' => $lang,
                    'href' => Url::to(['/', 'language' => $lang], true),
                ]);
            }

            // Определение изображения для языка
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

            $imageUrl = Yii::$app->request->hostInfo . $logo;

            // Open Graph теги
            Yii::$app->view->registerMetaTag([
                'property' => 'og:type',
                'content' => 'website',
            ], 'og:type');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:site_name',
                'content' => $siteName,
            ], 'og:site_name');

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

            Yii::$app->view->registerMetaTag([
                'property' => 'og:url',
                'content' => $currentUrl,
            ], 'og:url');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => $imageUrl,
            ], 'og:image');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:image:width',
                'content' => '1200',
            ], 'og:image:width');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:image:height',
                'content' => '630',
            ], 'og:image:height');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:image:alt',
                'content' => $t->meta_title ?: $t->title,
            ], 'og:image:alt');

            Yii::$app->view->registerMetaTag([
                'property' => 'og:locale',
                'content' => $this->getOgLocale($language),
            ], 'og:locale');

            // Twitter Card теги
            Yii::$app->view->registerMetaTag([
                'name' => 'twitter:card',
                'content' => 'summary_large_image',
            ], 'twitter:card');

            Yii::$app->view->registerMetaTag([
                'name' => 'twitter:title',
                'content' => $t->meta_title ?: $t->title,
            ], 'twitter:title');

            if (!empty($t->meta_description)) {
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:description',
                    'content' => $t->meta_description,
                ], 'twitter:description');
            }

            Yii::$app->view->registerMetaTag([
                'name' => 'twitter:image',
                'content' => $imageUrl,
            ], 'twitter:image');

            Yii::$app->view->registerMetaTag([
                'name' => 'twitter:image:alt',
                'content' => $t->meta_title ?: $t->title,
            ], 'twitter:image:alt');
        }
    }

    /**
     * Получить правильный формат locale для Open Graph
     */
    protected function getOgLocale(string $language): string
    {
        $locales = [
            'en' => 'en_US',
            'ru' => 'ru_RU',
            'uz' => 'uz_UZ',
            'ka' => 'ka_GE',
        ];

        return $locales[$language] ?? 'en_US';
    }

}
