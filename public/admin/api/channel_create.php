<?php
require_once __DIR__ . '/../../../app/Core/Database.php';
require_once __DIR__ . '/../../../app/Models/Channel.php';

use App\Models\Channel;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$name = trim($_POST['name'] ?? '');
if ($name === '') {
    http_response_code(400);
    echo 'Name required';
    exit;
}

$channel = new Channel();
$channel->create($name);
echo 'OK';
