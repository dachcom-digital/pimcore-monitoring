<?php

/*
 * This source file is available under two different licenses:
 *   - GNU General Public License version 3 (GPLv3)
 *   - DACHCOM Commercial License (DCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) DACHCOM.DIGITAL AG (https://www.dachcom-digital.com)
 * @license    GPLv3 and DCL
 */

namespace MonitoringBundle\Controller;

use MonitoringBundle\Check\Check;
use MonitoringBundle\Configuration\Configuration;
use MonitoringBundle\Module\MailLogModule;
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

    /**
     * @throws AccessDeniedHttpException
     */
    public function fetchEmailLogAction(Request $request, MailLogModule $mailLogModule): JsonResponse
    {
        if (!$this->checkAuth($request)) {
            throw new AccessDeniedHttpException();
        }

        if (!$this->configuration->moduleIsEnabled('email_log')) {
            throw new AccessDeniedHttpException();
        }

        $onlyErrors = $request->request->get('onlyErrors', 'false');
        $startingFrom = $request->request->get('startingFrom', null);
        $limit = $request->request->get('limit', null);

        $parameters = [
            'onlyErrors'   => $onlyErrors === 'true',
            'startingFrom' => $startingFrom,
            'limit'        => $limit,
        ];

        try {
            $data = $mailLogModule->dispatch($parameters);
        } catch (\Throwable) {
            return new JsonResponse(['error' => 'error while dispatching module'], 500);
        }

        return new JsonResponse($data, 200);
    }

    protected function checkAuth(Request $request): bool
    {
        $userSecret = $request->request->get('apiCode', '');

        return $userSecret === $this->configuration->getApiCode();
    }
}
