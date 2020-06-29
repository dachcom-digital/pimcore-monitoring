<?php

namespace MonitoringBundle\Service;

use Pimcore\Extension\Bundle\PimcoreBundleManager;
use Pimcore\Extension\Document\Areabrick\AreabrickManager;
use Pimcore\Kernel;
use Pimcore\Model\User;
use Pimcore\Version;
use SensioLabs\Security\SecurityChecker;

class WatchDog
{
    /**
     * @var PimcoreBundleManager
     */
    protected $pimcoreBundleManager;

    /**
     * @var AreabrickManager
     */
    protected $areabrickManager;

    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * @param PimcoreBundleManager $pimcoreBundleManager
     * @param AreabrickManager     $areabrickManager
     * @param Kernel               $kernel
     */
    public function __construct(
        PimcoreBundleManager $pimcoreBundleManager,
        AreabrickManager $areabrickManager,
        Kernel $kernel
    ) {
        $this->pimcoreBundleManager = $pimcoreBundleManager;
        $this->areabrickManager = $areabrickManager;
        $this->kernel = $kernel;
    }

    /**
     * @return array
     */
    public function getCoreInfo()
    {
        return [
            'version'  => Version::getVersion(),
            'revision' => Version::getRevision()
        ];
    }

    /**
     * @return array
     */
    public function getBricksInfo()
    {
        $bricks = [];
        foreach ($this->areabrickManager->getBricks() as $brickName => $brickInfo) {
            $brick = $this->areabrickManager->getBrick($brickName);

            $desc = $brick->getDescription();
            if (empty($desc) && $newDesc = $brick->getId()) {
                $desc = $newDesc;
            }

            $bricks[$brickName] = [
                'description' => $desc,
                'name'        => $brick->getName(),
                'isEnabled'   => $this->areabrickManager->isEnabled($brickName),
            ];
        }
        return $bricks;
    }

    /**
     * @return array
     */
    public function getUsersInfo()
    {
        $userListing = new User\Listing();

        $users = [];
        foreach ($userListing->getUsers() as $user) {

            if (!$user instanceof User) {
                continue;
            }

            $users[] = [
                'name'       => $user->getName(),
                'active'     => $user->isActive(),
                'is_admin'   => $user->isAdmin(),
                'last_login' => $user->getLastLogin(),
            ];
        }

        return $users;
    }

    /**
     * @return array
     */
    public function getFailedLoginsInfo()
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
                    'date'     => isset($data[0]) ? $data[0] : null,
                    'ip'       => isset($data[1]) ? $data[1] : null,
                    'username' => isset($data[2]) ? $data[2] : null,
                ];

                if ($c + 1 >= $maxEntries) {
                    break;
                }
            }
        }

        return $entries;
    }

    /**
     * @return array
     */
    public function getExtensionsInfo()
    {
        $extensions = [];

        foreach ($this->pimcoreBundleManager->getActiveBundles() as $bundle) {
            array_push($extensions, [
                'title'      => $bundle->getNiceName(),
                'version'    => $bundle->getVersion(),
                'identifier' => $this->pimcoreBundleManager->getBundleIdentifier($bundle),
                'isEnabled'  => $this->pimcoreBundleManager->isEnabled($bundle),
            ]);
        }

        return $extensions;
    }

    /**
     * @return array
     */
    public function getSecurityCheck()
    {
        $checker = new SecurityChecker();

        try {
            $data = $checker->check($this->kernel->getProjectDir());
        } catch (\Exception $e) {
            // fail silently
            return [];
        }

        if ($data->count() > 0) {
            return json_decode((string) $data, true);
        }

        return [];
    }
}
