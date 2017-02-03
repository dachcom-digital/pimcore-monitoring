<?php

namespace Monitoring;

use Pimcore\API\Plugin as PluginLib;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    public function init()
    {
        parent::init();
    }

    public static function needsReloadAfterInstall()
    {
        return FALSE;
    }

    public static function install()
    {
        return TRUE;
    }

    public static function uninstall()
    {
        return TRUE;
    }

    public static function isInstalled()
    {
        return TRUE;
    }
}
