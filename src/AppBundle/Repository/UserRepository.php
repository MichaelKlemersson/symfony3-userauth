<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository as BaseRepository;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 */
class UserRepository extends BaseRepository
{
    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        /** @var User|null $user */
        $user = parent::findOneBy($criteria, $orderBy);

        return $user;
    }
}
