<!-- public/admin/create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Channel</title>
</head>
<body>
    <h1>Create New Channel</h1>
    <form action="/admin/store" method="POST" id="createChannelForm">
        <label for="name">Channel Name:</label><br />
        <input type="text" name="name" id="name" required /><br /><br />
        <button type="submit">Create</button>
    </form>
    <a href="/admin">Back to Channels List</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('#createChannelForm, #editChannelForm').on('submit', function(e){
        const name = $('#name').val().trim();
        if(name === '') {
            alert('Channel name cannot be empty');
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>
