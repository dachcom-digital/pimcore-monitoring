<?php

namespace MonitoringBundle\Check;

use Pimcore\Extension\Document\Areabrick\AreabrickManager;

class BricksCheck implements CheckInterface
{
    public function __construct(protected AreabrickManager $areaBrickManager)
    {
    }

    public function getCheckReportIdentifier(): string
    {
        return 'bricks';
    }

    public function getCheckReport(): array
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
}
