<?php

namespace gambit\banner\rotator;

/**
 * This is just an example.
 */
class Rotate extends AbstractRotate
{

    public $class_wrap = 'show_banner';
    public $banners = [];

    /**
     * Наименование шаблона обертки для баннеров
     * @var string
     */
    public $view;

    /**
     * шаблон обертки баннеров по умолчанию
     * @var type 
     */
    public $template = '<div class="{class_wrap}">{banner}</div>';

    public function init()
    {
        parent::init();
        $config = \yii\helpers\ArrayHelper::merge($this->config, $this->getConfigDefault());
        $this->setInstance();
    }

    public function renderItem($item)
    {
        
    }

    public function renderItems()
    {
        if (!is_array($this->items)) {
            return;
        }
        foreach ($this->items as $banner) {
            $this->banners[] = $this->renderItem($banner);
        }
    }

    public function run()
    {
        return $this->rotateInstance->render($this->view, ['banners' => $this->banners]);
    }
}
