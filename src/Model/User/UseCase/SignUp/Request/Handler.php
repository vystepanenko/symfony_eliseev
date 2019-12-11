<?php


namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\ConfirmTokenizer;
use App\Model\User\Service\ConfirmTokenSender;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private $users;
    private $hasher;
    private $tokenizer;
    private $sender;
    private $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        ConfirmTokenizer $tokenizer,
        ConfirmTokenSender $sender,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User already exists');
        }

        $user = new User(
            Id::next(),
            new \DateTimeImmutable(),
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->generate()
        );

        $this->users->add($user);
        $this->sender->send($email, $token);
        $this->flusher->flush();

    }
}


///**
// * Class Handler
// * @package App\Model\User\UseCase\SignUp\Request
// */
//class Handler
//{
//    private  $em;
//
//    public function __construct(EntityManagerInterface $em)
//    {
//        $this->em = $em;
//    }
//
//    /**
//     * @param Command $command
//     * @throws \Exception
//     */
//    public function handle(Command $command): void
//    {
//        $email = mb_strtolower($command->email);
//
//        if ($this->em->getRepository(User::class)->findOneBy(['email'=>$email])){
//            throw new \DomainException('User already exist');
//        }
//
//
//        $user = new User(
//            Uuid::uuid4()->toString(),
//            new \DateTimeImmutable(),
//            $email,
//            password_hash($command->password, PASSWORD_ARGON2I)
//        );
//
//        $this->em->persist($user);
//        $this->em->flush();
//    }
//}