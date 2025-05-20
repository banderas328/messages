<?php
require_once __DIR__ . '/../../../app/Core/Database.php';
require_once __DIR__ .'/../../../app/Models/Channel.php';

use App\Models\Channel;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
http_response_code(405);
exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
http_response_code(400);
echo 'Invalid ID';
exit;
}

$channel = new Channel();
$channel->delete($id);
echo 'OK';