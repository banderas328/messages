<?php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/Message.php';

use App\Models\Message;

header('Content-Type: application/json');

$channelId = $_GET['channel_id'] ?? null;
if (!$channelId || !is_numeric($channelId)) {
    http_response_code(400);
    echo json_encode(['error' => 'channel_id required']);
    exit;
}

$messageModel = new Message();
$messages = $messageModel->getLastMessagesByChannel((int)$channelId, 20);

echo json_encode($messages);
