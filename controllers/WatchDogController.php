<?php

use Monitoring\Model\WatchDog;
use Monitoring\Plugin;

class Monitoring_WatchDogController extends \Pimcore\Controller\Action\Admin
{
    public function init()
    {
        if (!Plugin::isInstalled() || !WatchDog::checkAuth($this->getParam('secret', FALSE))) {
            $this
                ->getResponse()
                ->clearHeaders()
                ->setHttpResponseCode(403)
                ->appendBody('Forbidden')
                ->sendResponse();
            exit;
        }

        parent::init();
    }

    public function fetchAction()
    {
        $this->disableViewAutoRender();

        $this->_helper->json([

            'core'       => WatchDog::getCoreInfo(),
            'extensions' => WatchDog::getExtensionsInfo(),
            'bricks'     => WatchDog::getBricksInfo(),
            'extra'      => WatchDog::getSystemHealth()

        ]);
    }
}