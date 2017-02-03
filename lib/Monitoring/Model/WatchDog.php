<?php

namespace Monitoring\Model;

class WatchDog
{
    public static function checkAuth($key = NULL)
    {
        return $key === 'XXX';
    }

    public static function getCoreInfo()
    {
        return [
            'version'  => \Pimcore\Version::getVersion(),
            'revision' => \Pimcore\Version::getRevision()
        ];
    }

    public static function getExtensionsInfo()
    {
        $extensions = [];

        foreach (\Pimcore\ExtensionManager::getPluginConfigs() as $extension) {
            if (!isset($extension['plugin'])) {
                continue;
            }

            $pluginInfo = $extension['plugin'];

            $extensions[strtolower($pluginInfo['pluginName'])] = [
                'title'       => $pluginInfo['pluginName'],
                'description' => $pluginInfo['pluginDescription'],
                'version'     => strtolower($pluginInfo['pluginVersion']),
                'revision'    => strtolower($pluginInfo['pluginRevision']),
                'isLoaded'    => \Pimcore\ExtensionManager::isEnabled('plugin', $pluginInfo['pluginName'])
            ];
        }

        return $extensions;
    }

    public static function getBricksInfo()
    {
        $bricks = [];

        foreach (\Pimcore\ExtensionManager::getBrickConfigs() as $brickName => $brickInfo) {

            $bricks[strtolower($brickName)] = [
                'title'       => $brickName,
                'isLoaded'    => \Pimcore\ExtensionManager::isEnabled('brick', $brickName)
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
