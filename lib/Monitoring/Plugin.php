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

    public static function getConfig()
    {
        if (!self::isInstalled()) {
            return FALSE;
        }

        return include(self::getConfigFilePath());
    }

    public static function install()
    {
        if (self::isInstalled()) {
            return FALSE;
        }

        $data = ['authKey' => NULL];
        \Pimcore\File::putPhpFile(self::getConfigFilePath(), to_php_data_file_format($data));

        return TRUE;
    }

    public static function uninstall()
    {
        return TRUE;
    }

    public static function isInstalled()
    {
        return is_file(self::getConfigFilePath());
    }

    private static function getConfigFilePath()
    {
        return PIMCORE_CONFIGURATION_DIRECTORY . '/monitoring_configuration.php';
    }
}
