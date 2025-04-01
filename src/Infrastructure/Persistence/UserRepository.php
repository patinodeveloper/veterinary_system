<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\User;
use VetApp\Domain\Repositories\UserRepositoryInterface;
use Config\Database;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['password'],
            $userData['role']
        );
    }

    public function save(User $user): void {}
}
