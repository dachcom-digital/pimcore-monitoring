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

namespace MonitoringBundle\Check;

use Pimcore\Model\User;

class UserCheck implements CheckInterface
{
    public function getCheckReportIdentifier(): string
    {
        return 'users';
    }

    public function getCheckReport(): array
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
}
