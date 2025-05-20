<?php
// app/Controllers/AdminController.php

require_once __DIR__ . '/../Core/Database.php';

class AdminController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // List channels
    public function index()
    {
        $stmt = $this->db->query("SELECT id, name FROM channels ORDER BY id DESC");
        $channels = $stmt->fetchAll();

        require __DIR__ . '/../../public/admin/index.php';
    }

    // Show create form
    public function create()
    {
        require __DIR__ . '/../../public/admin/create.php';
    }

    // Store new channel
    public function store()
    {
        $name = $_POST['name'] ?? '';
        if (trim($name) === '') {
            header('Location: /admin/create?error=empty_name');
            exit;
        }

        $stmt = $this->db->prepare("INSERT INTO channels (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);

        header('Location: /admin');
        exit;
    }

    // Show edit form
    public function edit($id)
    {
        $stmt = $this->db->prepare("SELECT id, name FROM channels WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $channel = $stmt->fetch();

        if (!$channel) {
            http_response_code(404);
            echo "Channel not found";
            exit;
        }

        require __DIR__ . '/../../public/admin/edit.php';
    }

    // Update channel
    public function update($id)
    {
        $name = $_POST['name'] ?? '';
        if (trim($name) === '') {
            header("Location: /admin/edit/$id?error=empty_name");
            exit;
        }

        $stmt = $this->db->prepare("UPDATE channels SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);

        header('Location: /admin');
        exit;
    }

    // Delete channel
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM channels WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: /admin');
        exit;
    }
}
