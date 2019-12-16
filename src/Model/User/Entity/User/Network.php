<?php


namespace App\Model\User\Entity\User;


use Ramsey\Uuid\Uuid;

class Network
{
    /**
     * @var string
     */
    private $network;
    /**
     * @var string
     */
    private $identity;
    /**
     * @var string
     */
    private $id;
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user, string $network, string $identity)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->network = $network;
        $this->identity = $identity;
    }

    public function isForNetwork(string $network)
    {
        return $this->network === $network;
    }

    /**
     * @return string
     */
    public function getNetwork(): string
    {
        return $this->network;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }


}