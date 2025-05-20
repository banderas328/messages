<?php
require_once __DIR__ . '/../../../app/Core/Database.php';
require_once __DIR__ . '/../../../app/Models/Channel.php';

use App\Models\Channel;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');

if ($id <= 0 || $name === '') {
    http_response_code(400);
    echo 'Invalid input';
    exit;
}

$channel = new Channel();
$channel->update($id, $name);
echo 'OK';
