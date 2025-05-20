<?php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/Channel.php';

use App\Models\Channel;

header('Content-Type: application/json');

$channelModel = new Channel();
$channels = $channelModel->getAll();

echo json_encode($channels);
