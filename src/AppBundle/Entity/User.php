<?php

namespace AppBundle\Entity;

use DateTime;
use FOS\UserBundle\Model\User as BaseEntity;

class User extends BaseEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $lastUpdatedPasswordDate;

    /**
     * @return DateTime|null
     */
    public function getLastUpdatedPasswordDate(): ?DateTime
    {
        return $this->lastUpdatedPasswordDate;
    }

    /**
     * @param DateTime $lastUpdatedPasswordDate
     */
    public function setLastUpdatedPasswordDate(DateTime $lastUpdatedPasswordDate)
    {
        $this->lastUpdatedPasswordDate = $lastUpdatedPasswordDate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getUsername(),
            'email' => $this->getEmail(),
        ];
    }
}
