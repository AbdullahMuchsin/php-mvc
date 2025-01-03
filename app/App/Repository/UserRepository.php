<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use PDO;

class UserRepository
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO users (id, name, password) VALUE (?, ?, ?)");

        $statement->execute([
            $user->id,
            $user->name,
            $user->password
        ]);

        return $user;
    }
}
