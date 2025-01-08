<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use PDO;
use PDOException;

class UserRepository
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        try {
            $statement = $this->connection->prepare("INSERT INTO users (id, name, password) VALUES (?,?,?);");

            $statement->execute([
                $user->id,
                $user->name,
                $user->password
            ]);

            return $user;
        } catch (PDOException $e) {
            var_dump($e);
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(String $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, name, password FROM users WHERE id = ?");
        $statement->execute([$id]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->id = $row["id"];
            $user->name = $row["name"];
            $user->password = $row["password"];

            return $user;
        } else {
            return null;
        }
    }


    public function update(User $user): User
    {
        $statement = $this->connection->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
        $statement->execute([$user->name, $user->password, $user->id]);

        return $user;
    }

    public function deleteAll(): void
    {
        try {
            $statement = $this->connection->prepare("DELETE FROM users");
            $statement->execute();
        } finally {
            $statement->closeCursor();
        }
    }
}
