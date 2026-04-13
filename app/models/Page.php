<?php

declare(strict_types=1);

class Page
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
        $sql = 'SELECT id, title, slug, status, author_id, created_at, updated_at FROM pages ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function published(): array
    {
        $sql = "SELECT id, title, slug, status, author_id, created_at, updated_at FROM pages WHERE status = 'published' ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $sql = 'SELECT id, title, content, slug, status, author_id, created_at, updated_at FROM pages WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page !== false ? $page : null;
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = 'SELECT id, title, content, slug, status, author_id, created_at, updated_at FROM pages WHERE slug = :slug LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':slug' => $slug]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page !== false ? $page : null;
    }

    public function create(string $title, string $content, string $status, int $authorId): bool
    {
        $slug = $this->generateUniqueSlug($title);
        $sql = 'INSERT INTO pages (title, content, slug, status, author_id) VALUES (:title, :content, :slug, :status, :author_id)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':slug' => $slug,
            ':status' => $status,
            ':author_id' => $authorId,
        ]);
    }

    public function update(int $id, string $title, string $content, string $status): bool
    {
        $slug = $this->generateUniqueSlug($title, $id);
        $sql = 'UPDATE pages SET title = :title, content = :content, slug = :slug, status = :status WHERE id = :id';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':slug' => $slug,
            ':status' => $status,
            ':id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM pages WHERE id = :id';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = $this->slugify($title);
        $slug = $base;
        $suffix = 1;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    private function slugify(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? '';
        $slug = trim($slug, '-');

        return $slug === '' ? 'page' : $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $sql = 'SELECT id FROM pages WHERE slug = :slug';
        $params = [':slug' => $slug];

        if ($ignoreId !== null) {
            $sql .= ' AND id != :id';
            $params[':id'] = $ignoreId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
