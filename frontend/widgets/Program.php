<?php

namespace frontend\widgets;

use common\models\EventProgram;
use common\models\PageSections;
use common\models\Settings;
use yii\base\Widget;

class Program extends Widget
{
    public function run()
    {
        $section = PageSections::find()->where(['name' => 'program_header'])->one();

        $programs = EventProgram::find()
            ->where(['status' => 1])
            ->orderBy(['day' => SORT_ASC, 'start_time' => SORT_ASC])
            ->all();

        $days = [];
        foreach ($programs as $program) {
            if (!in_array($program->day, $days)) {
                $days[] = $program->day;
            }
        }

        $firstDay = $days[0] ?? null;
        $firstDayPrograms = array_filter($programs, function ($program) use ($firstDay) {
            return $program->day == $firstDay;
        });

        $partners = PageSections::getSection('partners_logo', 'home');
        $partners_left = PageSections::getSection('partners_left_text', 'home');
        $partners_right = PageSections::getSection('partners_right_text', 'home');

        return $this->render('program', [
            'section' => $section,
            'days' => $days,
            'firstDayPrograms' => $firstDayPrograms,
            'partners' => $partners,
            'partners_left' => $partners_left,
            'partners_right' => $partners_right,
        ]);
    }

}