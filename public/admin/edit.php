<!-- public/admin/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Channel</title>
</head>
<body>
    <h1>Edit Channel #<?= $channel['id'] ?></h1>
    <form action="/admin/update/<?= $channel['id'] ?>" method="POST" id="editChannelForm">
        <label for="name">Channel Name:</label><br />
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($channel['name']) ?>" required /><br /><br />
        <button type="submit">Update</button>
    </form>
    <a href="/admin">Back to Channels List</a>
</body>
</html>
