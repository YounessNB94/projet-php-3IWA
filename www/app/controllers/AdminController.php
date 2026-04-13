<?php

declare(strict_types=1);

class AdminController
{
    public function dashboard(): void
    {
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
