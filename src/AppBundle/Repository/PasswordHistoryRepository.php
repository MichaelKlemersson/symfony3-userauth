<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository as BaseRepository;

/**
 * Class PasswordHistoryRepository
 * @package AppBundle\Repository
 */
class PasswordHistoryRepository extends BaseRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function getUserLastFivePasswords(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('ph');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('userId', $user->getId()))
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
