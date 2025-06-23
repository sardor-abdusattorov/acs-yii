<?php

namespace common\components;


use kartik\editors\Summernote;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Editor extends Summernote
{
    protected function initWidget()
    {
        $this->_msgCat = 'kveditor';
        $this->initI18N(__DIR__);
        $this->initLanguage('lang', true);
        if (!empty($this->options['placeholder']) && empty($this->pluginOptions['placeholder'])) {
            $this->pluginOptions['placeholder'] = $this->options['placeholder'];
        }
        if (!isset($this->pluginOptions['styleWithSpan'])) {
            $this->pluginOptions['styleWithSpan'] = $this->styleWithSpan;
        }
        $tag = ArrayHelper::remove($this->container, 'tag', 'div');
        if (!isset($this->container['id'])) {
            $this->container['id'] = $this->options['id'].'-container';
        }
        if (!isset($this->container['class'])) {
            $this->container['class'] = 'kv-editor-container';
        }
        $this->initKrajeePresets();
        $this->initHints();
        $this->registerAssets();

        return Html::tag($tag, $this->getInput('textarea'), $this->container);
    }
}