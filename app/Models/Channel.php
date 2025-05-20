<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Channel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT id, name FROM channels ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, name FROM channels WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public function create(string $name): int {
        $stmt = $this->db->prepare("INSERT INTO channels (name) VALUES (?)");
        $stmt->execute([$name]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $name): bool {
        $stmt = $this->db->prepare("UPDATE channels SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM channels WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
