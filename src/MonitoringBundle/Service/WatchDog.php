<?php

namespace MonitoringBundle\Service;

use Pimcore\Extension\Bundle\PimcoreBundleManager;
use Pimcore\Extension\Document\Areabrick\AreabrickManager;
use Pimcore\Kernel;
use Pimcore\Version;
use SensioLabs\Security\SecurityChecker;

/**
 * Class WatchDog
 *
 * @package MonitoringBundle\Service
 */
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
     * WatchDog constructor.
     *
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
        return $checker->check($this->kernel->getProjectDir());
    }
}