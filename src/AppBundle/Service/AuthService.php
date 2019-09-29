<?php

namespace AppBundle\Service;

use AppBundle\Entity\PasswordHistory;
use AppBundle\Entity\User;
use AppBundle\Repository\PasswordHistoryRepository;

/**
 * Class AuthService
 * @package AppBundle\Service
 */
class AuthService
{
    const UPDATE_PASSWORD_DAYS_THRESHOLD = 28;

    /**
     * @var PasswordHistoryRepository
     */
    private $passwordHistoryRepository;

    /**
     * AuthService constructor.
     * @param $passwordHistoryRepository
     */
    public function __construct(PasswordHistoryRepository $passwordHistoryRepository)
    {
        $this->passwordHistoryRepository = $passwordHistoryRepository;
    }

    public function userNeedsResetPassword(User $user)
    {
        $lastUpdate = $user->getLastUpdatedPasswordDate();

        if ($lastUpdate === null) {
            return false;
        }

        $currentDate = new \DateTime();
        $diffDate = $lastUpdate->diff($currentDate);

        return $diffDate->days >= self::UPDATE_PASSWORD_DAYS_THRESHOLD;
    }

    /**
     * Checks if the current user has used its password on the last 5 old passwords
     *
     * @param User $user
     * @return bool
     */
    public function hasUsedPassword(User $user)
    {
        $lastPasswords = $this->passwordHistoryRepository->getUserLastFivePasswords($user);

        $repeatedPasswords = array_filter($lastPasswords, function ($entry) use ($user) {
            return $user->getPassword() === $entry;
        });

        return count($repeatedPasswords) > 0;
    }
}
