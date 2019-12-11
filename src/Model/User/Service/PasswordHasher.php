<?php


namespace App\Model\User\Service;


class PasswordHasher
{
    public function hash(string $password)
    {
        $hash = password_hash($password, PASSWORD_ARGON2I);
        if ($hash === false) {
            throw new \RuntimeException('Unable to generate hash.');
        }
        return $hash;
    }
}