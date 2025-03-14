<?php namespace AliCemalTuran\AjaxWrapper;

use Backend;
use Cms\Classes\Controller;
use Cms\Facades\Cms;
use AliCemalTuran\AjaxWrapper\Extensions\WrappedAjaxTwigExtension;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'AjaxWrapper',
            'description' => 'Ajax Wrapper Div Customization',
            'author' => 'Ali Cemal Turan',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {

    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        \Event::listen('system.extendTwig', function ( $twig) {
            $twig->addExtension(new WrappedAjaxTwigExtension(Controller::getController()));
        });
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {

        return [
            'AliCemalTuran\AjaxWrapper\Components\WrappedAjax' => 'ajaxWrapped',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'alicemalturan.ajax-wrapper.some_permission' => [
                'tab' => 'AjaxClasser',
                'label' => 'Some permission'
            ],
        ];
    }


    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

    }
}
