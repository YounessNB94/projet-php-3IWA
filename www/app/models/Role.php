<?php

declare(strict_types=1);

class Role
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

    public function all(): array
    {
        $sql = 'SELECT id, name, description FROM roles ORDER BY id ASC';
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $sql = 'SELECT id, name, description FROM roles WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role !== false ? $role : null;
    }

    public function findByName(string $name): ?array
    {
        $sql = 'SELECT id, name, description FROM roles WHERE name = :name LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':name' => $name]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role !== false ? $role : null;
    }
}
