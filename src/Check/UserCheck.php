<?php

namespace MonitoringBundle\Check;

use MonitoringBundle\Check\CheckInterface;
use Pimcore\Model\User;
use Pimcore\Version;

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
