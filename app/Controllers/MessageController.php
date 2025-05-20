<?php

namespace App\Controllers;

use App\Models\Message;

/**
 * MessageController
 * 
 * Handles HTTP requests related to messages.
 */
class MessageController
{
    public function index(): void
    {
        $messageModel = new Message();
        $messages = $messageModel->getAll();

        header('Content-Type: application/json');
        echo json_encode($messages);
    }
}
