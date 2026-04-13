<?php

declare(strict_types=1);

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $configPath = __DIR__ . '/../../config/database.php';
        if (!is_file($configPath)) {
            throw new RuntimeException('Database config missing.');
        }

        $config = require $configPath;

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['dbname'],
            $config['charset']
        );

        $this->connection = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
