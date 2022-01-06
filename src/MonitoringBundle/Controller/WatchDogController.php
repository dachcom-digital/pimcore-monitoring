<?php

namespace MonitoringBundle\Controller;

use MonitoringBundle\Configuration\Configuration;
use MonitoringBundle\Service\WatchDog;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WatchDogController extends FrontendController
{
    protected Configuration $configuration;
    protected WatchDog $watchDog;

    public function __construct(Configuration $configuration, WatchDog $watchDog)
    {
        $this->configuration = $configuration;
        $this->watchDog = $watchDog;
    }

    /**
     * @throws AccessDeniedHttpException
     */
    public function fetchAction(Request $request): JsonResponse
    {
        if (!$this->checkAuth($request)) {
            throw new AccessDeniedHttpException();
        }

        return new JsonResponse([
            'core'           => $this->watchDog->getCoreInfo(),
            'extensions'     => $this->watchDog->getExtensionsInfo(),
            'bricks'         => $this->watchDog->getBricksInfo(),
            'users'          => $this->watchDog->getUsersInfo(),
            'failed_logins'  => $this->watchDog->getFailedLoginsInfo()
        ], 200);
    }

    protected function checkAuth(Request $request): bool
    {
        $userSecret = $request->request->get('apiCode', '');

        return $userSecret === $this->configuration->getApiCode();
    }
}
