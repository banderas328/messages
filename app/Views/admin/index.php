<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Channels and Calls</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
/* Простые стили */
#channelsList { margin-bottom: 20px; }
.channel { padding: 5px; border-bottom: 1px solid #ccc; }
.admin-link { margin-bottom: 10px; display: block; }
</style>
</head>
<body>

<a href="/admin" class="admin-link">⚙️ Manage Channels (Admin)</a>

<h1>Channels</h1>
<div id="channelsList"></div>

<script>
function loadChannels() {
    $.ajax({
        url: '/api/channels', // предполагается API для получения каналов
        method: 'GET',
        success: function(data) {
            let html = '';
            data.forEach(ch => {
                html += `<div class="channel">#${ch.id}: ${ch.name}</div>`;
            });
            $('#channelsList').html(html);
        }
    });
}

$(function(){
    loadChannels();
});
</script>

</body>
</html>
