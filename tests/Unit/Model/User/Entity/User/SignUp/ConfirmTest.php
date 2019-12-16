<?php


namespace App\Tests\Unit\Model\User\Entity\User\SignUp;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new  User(
            $id = Id::next(),
            $date = new \DateTimeImmutable()
        );

        $user->signUpByEmail(
            $email = new Email('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $user->confirmSignUp();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertNull($user->getConfirmToken());
    }

    public function testAlready(): void
    {
        $user = new  User(
            $id = Id::next(),
            $date = new \DateTimeImmutable()
        );

        $user->signUpByEmail(
            $email = new Email('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $user->confirmSignUp();
        $this->expectExceptionMessage('User is already confirmed.');
        $user->confirmSignUp();
    }
}