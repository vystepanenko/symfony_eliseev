<?php


namespace App\Model\User\UseCase\Reset\Reset;


class Command
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $password;

    /**
     * Command constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }
}