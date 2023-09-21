<?php

namespace MonitoringBundle\Service;

use Pimcore\Extension\Bundle\PimcoreBundleManager;
use Pimcore\Extension\Document\Areabrick\AreabrickManager;
use Pimcore\Kernel;
use Pimcore\Model\User;
use Pimcore\Version;

class WatchDog
{
    public function __construct(
        protected PimcoreBundleManager $pimcoreBundleManager,
        protected AreabrickManager $areaBrickManager,
        protected Kernel $kernel
    ) {
    }

    public function getCoreInfo(): array
    {
        return [
            'version'  => Version::getVersion(),
            'revision' => Version::getRevision()
        ];
    }

    public function getBricksInfo(): array
    {
        $bricks = [];
        foreach ($this->areaBrickManager->getBricks() as $brickName => $brickInfo) {
            $brick = $this->areaBrickManager->getBrick($brickName);

            $desc = $brick->getDescription();
            if (empty($desc) && $newDesc = $brick->getId()) {
                $desc = $newDesc;
            }

            $bricks[$brickName] = [
                'description' => $desc,
                'name'        => $brick->getName(),
                'isEnabled'   => true,
            ];
        }
        return $bricks;
    }

    public function getUsersInfo(): array
    {
        $userListing = new User\Listing();

        $users = [];
        foreach ($userListing->getUsers() as $user) {

            if (!$user instanceof User) {
                continue;
            }

            $lastLogin = 0;

            try {
                $lastLogin = $user->getLastLogin();
            } catch (\Throwable) {
                // fail silently: "User::$lastLogin must not be accessed before initialization"
            }

            $users[] = [
                'name'       => $user->getName(),
                'active'     => $user->isActive(),
                'is_admin'   => $user->isAdmin(),
                'last_login' => $lastLogin,
            ];
        }

        return $users;
    }

    public function getFailedLoginsInfo(): array
    {
        $maxEntries = 50;
        $logFile = PIMCORE_LOG_DIRECTORY . '/loginerror.log';

        if (!file_exists($logFile)) {
            return [];
        }

        $logData = file_get_contents($logFile);

        $lines = explode("\n", $logData);
        $entries = [];

        if (is_array($lines) && count($lines) > 0) {

            // latest first!
            $lines = array_reverse($lines);

            foreach ($lines as $c => $line) {

                if (empty($line)) {
                    continue;
                }

                $data = explode(',', $line);

                $entries[] = [
                    'date'     => $data[0] ?? null,
                    'ip'       => $data[1] ?? null,
                    'username' => $data[2] ?? null,
                ];

                if ($c + 1 >= $maxEntries) {
                    break;
                }
            }
        }

        return $entries;
    }

    public function getExtensionsInfo(): array
    {
        $extensions = [];

        foreach ($this->pimcoreBundleManager->getActiveBundles() as $bundle) {
            $extensions[] = [
                'title'       => $bundle->getNiceName(),
                'version'     => $bundle->getVersion(),
                'identifier'  => $this->pimcoreBundleManager->getBundleIdentifier($bundle),
                'isInstalled' => $this->pimcoreBundleManager->isInstalled($bundle),
            ];
        }

        return $extensions;
    }
}
