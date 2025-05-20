<!-- app/Views/admin/edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Channel</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { max-width: 400px; }
        label, input { display: block; margin-bottom: 10px; width: 100%; }
        input[type="text"] { padding: 8px; }
        button { padding: 10px 20px; background: #2196F3; color: white; border: none; cursor: pointer; }
        a { display: inline-block; margin-top: 20px; color: blue; }
    </style>
</head>
<body>
    <h1>Edit Channel</h1>
    <form action="/admin/update/<?= $channel['id'] ?>" method="post">
        <label for="name">Channel Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($channel['name']) ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="/admin">← Back to list</a>
</body>
</html>
