<?php

namespace Tests\Unit\AppBundle\Entity;

use AppBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testSetUserLastUpdatedPasswordDate()
    {
        // prepare
        $currentDate = new \DateTime();
        $classUnderTest = new User();

        // assert
        $this->assertNull($classUnderTest->getLastUpdatedPasswordDate());

        // test
        $classUnderTest->setLastUpdatedPasswordDate($currentDate);
        $lastDate = $classUnderTest->getLastUpdatedPasswordDate();

            // assert
        $this->assertEquals($currentDate->format(\DateTime::ATOM), $lastDate->format(\DateTime::ATOM));
    }
}
