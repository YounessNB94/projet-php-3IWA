<?php

declare(strict_types=1);

class User
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        if ($db instanceof PDO) {
            $this->db = $db;
            return;
        }

        if (class_exists('Database')) {
            $this->db = Database::getInstance()->getConnection();
            return;
        }

        throw new RuntimeException('Database connection missing.');
    }

  
    public function create(string $name, string $email, string $passwordHash, int $roleId): bool
    {
        $sql = 'INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash,
            ':role_id' => $roleId,
        ]);
    }

  
    public function findByEmail(string $email): ?array
    {
        $sql = 'SELECT id, name, email, password, role_id, created_at FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }

    
    public function findById(int $id): ?array
    {
        $sql = 'SELECT id, name, email, role_id, created_at FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }
}
