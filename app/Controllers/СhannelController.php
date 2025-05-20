<?php

namespace App\Controllers;

use App\Models\Channel;

/**
 * ChannelController
 * Контроллер для управления каналами (CRUD).
 * Controller for managing channels (CRUD).
 */
class ChannelController
{
    // Show list of all channels
    public function index()
    {
        $channels = Channel::all();
        include __DIR__ . '/../Views/admin/index.php';
    }

    // Show form to create new channel
    public function create()
    {
        include __DIR__ . '/../Views/admin/create.php';
    }

    // Store new channel
    public function store()
    {
        $name = $_POST['name'] ?? '';
        if ($name) {
            Channel::create(['name' => $name]);
        }
        header('Location: /admin');
    }

    // Show form to edit channel
    public function edit($id)
    {
        $channel = Channel::find($id);
        include __DIR__ . '/../Views/admin/edit.php';
    }

    // Update existing channel
    public function update($id)
    {
        $name = $_POST['name'] ?? '';
        if ($name) {
            Channel::update($id, ['name' => $name]);
        }
        header('Location: /admin');
    }

    // Delete channel
    public function destroy($id)
    {
        Channel::delete($id);
        header('Location: /admin');
    }
}
