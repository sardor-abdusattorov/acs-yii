<?php

namespace frontend\controllers;

use common\components\StaticFunctions;
use common\models\ArchiveNews;
use common\models\Articles;
use common\models\Books;
use common\models\EventProgram;
use common\models\Locations;
use common\models\PageSections;
use common\models\ProgramDate;
use common\models\ProgramSessions;
use common\models\Registration;
use common\models\Sections;
use common\models\Settings;
use common\models\SocialLinks;
use common\models\Subscribers;
use common\models\Tags;
use Yii;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => 'error',
                'layout' => 'error',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */

    public function actionIndex()
    {
        $social_links = SocialLinks::find()->where(['status' => 1])->orderBy(['order_by' => SORT_ASC])->all();
        $hero = PageSections::getSection('main_hero', 'home');

        $settings = Settings::getValues(['youtube_link']);
        $sections = Sections::find()
            ->where(['status' => 1])
            ->orderBy(['sort' => SORT_ASC])
            ->all();
        $books = Books::find()->where(['status' => 1])->orderBy(['order_by' => SORT_ASC])->all();
        $articles = Articles::find()->where(['status' => 1])->orderBy(['order_by' => SORT_ASC])->all();
        $partners = PageSections::getSection('partners_logo', 'home');
        $archive_hero = PageSections::getSection('archive_hero', 'home');

        $years = ArchiveNews::find()
            ->select(['year' => new Expression('YEAR(created_at)')])
            ->groupBy('year')
            ->orderBy(['year' => SORT_ASC])
            ->column();

        $activeYear = $years[0] ?? null;

        $archive_news = ArchiveNews::find()->where(['status' => 1])->orderBy(['order_by' => SORT_DESC])->all();

        $archive_gallery = PageSections::getSection('archive_gallery', 'home');

        $program_dates = ProgramDate::find()
            ->orderBy(['date' => SORT_ASC])
            ->all();

        $sessions = ProgramSessions::find()->orderBy(['sort' => SORT_ASC])->all();


        return $this->render('index', [
            'social_links' => $social_links,
            'hero' => $hero,
            'settings' => $settings,
            'sections' => $sections,
            'books' => $books,
            'articles' => $articles,
            'partners' => $partners,
            'archive_hero' => $archive_hero,
            'years' => $years,
            'activeYear' => $activeYear,
            'archive_news' => $archive_news,
            'archive_gallery' => $archive_gallery,
            'program_dates' => $program_dates,
            'sessions' => $sessions,
        ]);
    }

    public function actionRegister()
    {
        $model = new Registration();

        if ($model->load(Yii::$app->request->post())) {

            $model->sources = is_array($model->sources) ? implode(',', $model->sources) : null;
            $model->attendance_days = is_array($model->attendance_days) ? implode(',', $model->attendance_days) : null;

            if ($model->validate() && $model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successful!'));
            } else {
                $errors = [];
                foreach ($model->getFirstErrors() as $field => $error) {
                    $errors[] = $error;
                }
                Yii::$app->session->setFlash('error', Yii::t('app', 'Registration error! Please check your input.') . '<br>' . implode('<br>', $errors));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Invalid form submission.'));
        }

        return $this->redirect(['/site/index']);
    }

    public function actionSubscribe()
    {
        $model = new Subscribers();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for subscribing!'));
            }else {
                $errors = [];
                foreach ($model->getFirstErrors() as $field => $error) {
                    $errors[] = $error;
                }
                Yii::$app->session->setFlash('error', Yii::t('app', 'Subscription error. Please check your input.') . '<br>' . implode('<br>', $errors));
            }

            return $this->redirect(['/site/index']);
        }

        throw new BadRequestHttpException(Yii::t('app', 'Invalid request type.'));
    }

    public function actionGetPrograms()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $day = Yii::$app->request->post('day');

        if (empty($day)) {
            return ['success' => false, 'message' => 'Day parameter is required.'];
        }

        $programs = EventProgram::find()
            ->where(['status' => 1, 'day' => $day])
            ->with(['location.translations', 'tag.translations', 'translations'])
            ->orderBy(['start_time' => SORT_ASC])
            ->asArray()
            ->all();

        return ['success' => true, 'programs' => $programs];
    }

    public function actionGetArticle()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        $article = Articles::find()
            ->where(['id' => $id, 'status' => 1])
            ->with(['translations'])
            ->asArray()
            ->one();

        $article['image'] = StaticFunctions::getImage($article['image'], 'articles', $article['id']);

        if (!$article) {
            return ['success' => false, 'message' => 'Article not found'];
        }
        return ['success' => true, 'article' => $article];
    }

    public function actionArchiveYear()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $year = Yii::$app->request->post('year');

        if (!$year) {
            return ['success' => false, 'message' => 'Year is required'];
        }

        $old_locations = Locations::find()
            ->where(['status' => Locations::STATUS_ARCHIVED])
            ->andWhere(['YEAR(created_at)' => $year])
            ->orderBy(['order_by' => SORT_ASC])
            ->all();

        $archive_events = EventProgram::find()
            ->where(['status' => EventProgram::STATUS_ARCHIVED])
            ->andWhere(['YEAR(created_at)' => $year])
            ->orderBy(['order_by' => SORT_ASC])
            ->all();

        $eventYears = EventProgram::find()
            ->select(['year' => new Expression('YEAR(created_at)')])
            ->where(['status' => EventProgram::STATUS_ARCHIVED])
            ->groupBy('year')
            ->column();

        $locationYears = Locations::find()
            ->select(['year' => new Expression('YEAR(created_at)')])
            ->where(['status' => Locations::STATUS_ARCHIVED])
            ->groupBy('year')
            ->column();

        $years = array_unique(array_merge($eventYears, $locationYears));
        sort($years);

        $archive_hero = PageSections::getSection('archive_hero', 'home');
        $partners = PageSections::getSection('partners_logo', 'home');
        $tags = Tags::find()->where(['status' => 1])->orderBy(['order_by' => SORT_ASC])->all();

        $html = $this->renderPartial('_archive_content', [
            'archive_hero' => $archive_hero,
            'archive_events' => $archive_events,
            'old_locations' => $old_locations,
            'tags' => $tags,
            'partners' => $partners,
            'years' => $years,
            'activeYear' => $year,
        ]);

        return ['success' => true, 'html' => $html];
    }

}
