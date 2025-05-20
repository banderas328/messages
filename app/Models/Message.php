<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Message {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getLastMessagesByChannel(int $channelId, int $limit = 20): array {
        $stmt = $this->db->prepare("SELECT * FROM messages WHERE channel_id = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $channelId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_reverse($results); // oldest first
    }

    public function create(int $channelId, string $user, string $content): int {
        $stmt = $this->db->prepare("INSERT INTO messages (channel_id, user, content, created_at) VALUES (?, ?, ?, datetime('now'))");
        $stmt->execute([$channelId, $user, $content]);
        return (int)$this->db->lastInsertId();
    }
}
