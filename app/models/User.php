<?php

namespace app\models;

use Doctrine\DBAL\Connection;

class User
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function findAll()
    {                
        $sql = "SELECT * FROM users";

        $stmt = $this->db->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();       

        return $users;
    }

    public function find($id)
    {                
        $sql = "SELECT * FROM users WHERE id=:id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue("id", $id);
        $resultSet = $stmt->executeQuery();
        $user = $resultSet->fetchAssociative();       

        return $user;
    }
}