<?php

namespace Tests\Unit\AppBundle;

use AppBundle\Entity\User;
use AppBundle\Repository\PasswordHistoryRepository;
use AppBundle\Service\AuthService;

class AuthServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckIfUserNeedsResetPassword()
    {
        // prepare
        $user = new User();
        $updateDate = new \DateTime();
        $updateDate->modify('+28 day');
        $user->setLastUpdatedPasswordDate($updateDate);

        /** @var PasswordHistoryRepository|\PHPUnit_Framework_MockObject_MockObject $passwordHistoryRepositoryMock */
        $passwordHistoryRepositoryMock = $this->createMock(PasswordHistoryRepository::class);

        $classUnderTest = new AuthService($passwordHistoryRepositoryMock);

        // test
        $result = $classUnderTest->userNeedsResetPassword($user);

        // assert
        $this->assertTrue($result);
    }

    public function testValidateUserPasswordAgainstLastFivePasswords()
    {
        // prepare
        $user = new User();
        $user->setPassword(md5('test1'));

        /** @var PasswordHistoryRepository|\PHPUnit_Framework_MockObject_MockObject $passwordHistoryRepositoryMock */
        $passwordHistoryRepositoryMock = $this->createMock(PasswordHistoryRepository::class);
        $passwordHistoryRepositoryMock->method('getUserLastFivePasswords')->with($user)->willReturn([
            md5('test1'),
            md5('test2'),
            md5('test3'),
            md5('test4'),
            md5('test5'),
        ]);

        $classUnderTest = new AuthService($passwordHistoryRepositoryMock);

        // test
        $result = $classUnderTest->hasUsedPassword($user);

        // assert
        $this->assertTrue($result);
    }

    public function testUserDoesNotNeedResetPassword()
    {
        // prepare
        $user = new User();
        $updateDate = new \DateTime();
        $updateDate->modify('+26 day');
        $user->setLastUpdatedPasswordDate($updateDate);

        /** @var PasswordHistoryRepository|\PHPUnit_Framework_MockObject_MockObject $passwordHistoryRepositoryMock */
        $passwordHistoryRepositoryMock = $this->createMock(PasswordHistoryRepository::class);

        $classUnderTest = new AuthService($passwordHistoryRepositoryMock);

        // test
        $result = $classUnderTest->userNeedsResetPassword($user);

        // assert
        $this->assertFalse($result);
    }
}
