<?php namespace AliCemalTuran\AjaxWrapper\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Partial;
use Cms\Classes\Theme;
use const AliCemalTuran\AjaxWrapper\Components\dd as ddAlias;

/**
 * KumsalAjax Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class WrappedAjax extends ComponentBase
{
    public $partial;
    public $class;
    public $id;
    public function componentDetails()
    {
        return [
            'name' => 'Kumsal Ajax Component',
            'description' => 'Ajax Partial With Class',
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [
            'partial' => [
                'type' => 'dropdown',
                'emptyOption' => "Seçilmedi",
                "required" => true,
            ],
            'class'=>[
                'type'=>'text'
            ],
            "id"=>[
                "type" => 'text'
            ]
        ];
    }

    public function init()
    {
        $this->partial = str_replace('.htm','',$this->property('partial',''));
        $this->class = $this->property('class',' ');
        $this->id = $this->property('id',' ');
    }

    public function getPartialOptions()
    {
        return Partial::listInTheme(Theme::getActiveTheme())->lists('fileName', 'fileName');
    }

}
