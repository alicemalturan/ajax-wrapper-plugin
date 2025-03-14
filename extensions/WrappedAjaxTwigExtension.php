<?php

namespace AliCemalTuran\AjaxWrapper\Extensions;
use Cms\Classes\Controller;
use AliCemalTuran\AjaxWrapper\Classes\AjaxPartialTokenParser;
use AliCemalTuran\AjaxWrapper\Classes\WrapperPartialTokenParser;
use Twig\Extension\AbstractExtension as TwigExtension;

class WrappedAjaxTwigExtension extends TwigExtension
{
    /**
     * @var \Cms\Classes\Controller controller reference
     */
    protected $controller;

    /**
     * __construct the extension instance.
     */
    public function __construct(Controller $controller = null)
    {
        $this->controller = $controller;
    }

    public function getTokenParsers()
    {
        return [
            new AjaxPartialTokenParser,
            new WrapperPartialTokenParser
        ];
    }
}
