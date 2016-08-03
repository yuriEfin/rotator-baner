<?php

namespace gambit\banner\rotator;

/**
 * This is just an example.
 */
class Rotate extends AbstractRotate
{

    public $class_wrap = 'show_banner';
    public $banners = [];
    public $isNoIndex = true;

    /**
     * Наименование шаблона обертки для баннеров
     * @var string
     */
    public $view;

    /**
     * шаблон обертки баннеров по умолчанию
     * @var type 
     */
    public $template = '<div id="{id}" class="{class_wrap}">{banner}</div>';

    public function init()
    {
        parent::init();
        $this->setInstance();
    }

    public function renderItem($item)
    {
        $html = '';
        if ($this->isNoIndex) {
            $html .= '<noindex>';
        }
        $html .= strtr($this->template, [
            '{class_wrap}' => $this->class_wrap,
            '{id}' => $item['id'],
            '{banner}' => $this->getView()->renderDynamic(file_get_contents($item['path_file'])),
        ]);
        if ($this->isNoIndex) {
            $html .= '</noindex>';
        }
        return $html;
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
