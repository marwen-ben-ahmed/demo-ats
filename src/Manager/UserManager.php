<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manager layer for User entity.
 */
class UserManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository
    ) {}

    public function createUser(string $email, string $name): User
    {
        $user = new User();
        $user->setEmail($email)->setName($name);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    public function updateUser(User $user, string $email, string $name): User
    {
        $user->setEmail($email)->setName($name);
        $this->em->flush();
        return $user;
    }

    public function deleteUser(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function findUser(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}