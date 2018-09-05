<?php

namespace MonitoringBundle\Controller;

use MonitoringBundle\Configuration\Configuration;
use MonitoringBundle\Service\WatchDog;
use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class Monitoring_WatchDogController
 * @Route("/monitoring")
 * @Template()
 */
class WatchDogController extends FrontendController
{

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var WatchDog
     */
    protected $watchDog;

    /**
     * WatchDogController constructor.
     *
     * @param Configuration $configuration
     * @param WatchDog      $watchDog
     */
    public function __construct(Configuration $configuration, WatchDog $watchDog)
    {
        $this->configuration = $configuration;
        $this->watchDog = $watchDog;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws AccessDeniedHttpException
     *
     * @Route("/fetch")
     */
    public function fetchAction(Request $request)
    {
        if (!$this->checkAuth($request)) {
            throw new AccessDeniedHttpException();
        }

        return new JsonResponse([
            'core'           => $this->watchDog->getCoreInfo(),
            'extensions'     => $this->watchDog->getExtensionsInfo(),
            'bricks'         => $this->watchDog->getBricksInfo(),
            'security_check' => $this->watchDog->getSecurityCheck()
        ], 200);
    }

    /**
     * @param Request $request
     *
     * @return true|Response
     */
    private function checkAuth(Request $request)
    {
        $userSecret = $request->get('apiCode');
        return (isset($userSecret) && $userSecret === $this->configuration->getApiCode());
    }
}
