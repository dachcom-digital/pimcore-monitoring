<?php

namespace Monitoring\Model;

use \Pimcore\ExtensionManager;
use \Pimcore\Version;

class WatchDog
{
    public static function checkAuth($key = NULL)
    {
        $config = \Monitoring\Plugin::getConfig();
        return isset($config['authKey']) && $config['authKey'] === $key;
    }

    public static function getCoreInfo()
    {
        return [
            'version'  => Version::getVersion(),
            'revision' => Version::getRevision()
        ];
    }

    public static function getExtensionsInfo()
    {
        $extensions = [];

        foreach (ExtensionManager::getPluginConfigs() as $extension) {
            if (!isset($extension['plugin'])) {
                continue;
            }

            $pluginInfo = $extension['plugin'];

            $extensions[strtolower($pluginInfo['pluginName'])] = [
                'title'       => $pluginInfo['pluginName'],
                'description' => $pluginInfo['pluginDescription'],
                'version'     => strtolower($pluginInfo['pluginVersion']),
                'revision'    => strtolower($pluginInfo['pluginRevision']),
                'isLoaded'    => ExtensionManager::isEnabled('plugin', $pluginInfo['pluginName'])
            ];
        }

        return $extensions;
    }

    public static function getBricksInfo()
    {
        $bricks = [];

        foreach (ExtensionManager::getBrickConfigs() as $brickName => $brickInfo) {

            $brickInfo = $brickInfo->toArray();

            $bricks[strtolower($brickName)] = [
                'title'    => $brickName,
                'version'  => isset($brickInfo['version']) ? $brickInfo['version'] : NULL,
                'isLoaded' => ExtensionManager::isEnabled('brick', $brickName)
            ];
        }

        return $bricks;
    }

    public static function getSystemHealth()
    {
        return [
            'warning' => [],
            'danger'  => [],
            'info'    => []
        ];
    }
}
