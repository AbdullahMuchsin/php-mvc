<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PDO;

class SessionRepository
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $statement = $this->connection->prepare("INSERT INTO sessions (id, user_id) VALUES(?, ?)");
        $statement->execute([$session->id, $session->user_id]);

        return $session;
    }

    public function findById(string $id): ?Session
    {

        $statement = $this->connection->prepare("SELECT id, user_id sessions WHERE id = ?");
        $statement->execute([$id]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $session = new Session();
            $session->id = $row["id"];
            $session->user_id = $row["user_id"];

            return $session;
        } else {
            return null;
        }
    }

    public function deleteById(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $statement =  $this->connection->prepare("DELETE FROM sessions");
        $statement->execute();
    }
}
