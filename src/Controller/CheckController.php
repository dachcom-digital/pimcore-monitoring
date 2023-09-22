<?php

namespace MonitoringBundle\Controller;

use MonitoringBundle\Check\Check;
use MonitoringBundle\Configuration\Configuration;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckController extends FrontendController
{
    public function __construct(protected Configuration $configuration)
    {
    }

    /**
     * @throws AccessDeniedHttpException
     */
    public function fetchAction(Request $request, Check $check): JsonResponse
    {
        if (!$this->checkAuth($request)) {
            throw new AccessDeniedHttpException();
        }

        return new JsonResponse($check->dispatchCheck(), 200);
    }

    protected function checkAuth(Request $request): bool
    {
        $userSecret = $request->request->get('apiCode', '');

        return $userSecret === $this->configuration->getApiCode();
    }
}
