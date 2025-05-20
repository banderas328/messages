<?php
// public/index.php
// Basic API endpoints for channels and messages handled separately
// Here we render HTML + JS UI with jQuery and WebRTC calls

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Channels & WebRTC Calls</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
  body { font-family: Arial, sans-serif; margin: 20px; }
  #channelsList { margin-bottom: 20px; }
  .channel { padding: 5px; border-bottom: 1px solid #ccc; cursor: pointer; }
  #messages { border: 1px solid #ccc; height: 150px; overflow-y: scroll; margin-bottom: 10px; padding: 5px; }
  #videos { display: flex; gap: 10px; margin-top: 20px; }
  video { width: 300px; height: 225px; background: black; }
  #callControls { margin-top: 10px; }
  #adminPanel { margin-top: 40px; border-top: 1px solid #aaa; padding-top: 20px; }
</style>
</head>
<body>

<h1>Channels</h1>
<div id="channelsList"></div>

<h2>Messages</h2>
<div id="messages"></div>
<input type="text" id="messageInput" placeholder="Type a message" style="width: 80%;">
<button id="sendMessageBtn">Send</button>

<h2>WebRTC Video Call</h2>
<video id="localVideo" autoplay muted></video>
<video id="remoteVideo" autoplay></video>

<div id="callControls">
  <button id="startCallBtn">Start Call</button>
  <button id="hangupCallBtn" disabled>Hang Up</button>
</div>

<div id="adminPanel">
  <h2>Admin: Manage Channels</h2>
  <input type="text" id="newChannelName" placeholder="New Channel Name">
  <button id="addChannelBtn">Add Channel</button>
  <ul id="adminChannelsList"></ul>
</div>

<script>
let currentChannelId = null;
let ws = null;
let localStream = null;
let peerConnection = null;

const signalingServerUrl = "ws://localhost:8765";
const iceServers = [{ urls: "stun:stun.l.google.com:19302" }];

// Load channels and populate lists
function loadChannels() {
    $.getJSON('/api/channels.php', function(data){
        $('#channelsList').empty();
        $('#adminChannelsList').empty();
        data.forEach(ch => {
            $('#channelsList').append(`<div class="channel" data-id="${ch.id}">#${ch.id} ${ch.name}</div>`);
            $('#adminChannelsList').append(`<li data-id="${ch.id}">${ch.name} <button class="deleteChannelBtn">Delete</button></li>`);
        });
    });
}

// Load last 20 messages of channel
function loadMessages(channelId) {
    $.getJSON(`/api/messages.php?channel_id=${channelId}`, function(data){
        $('#messages').empty();
        data.forEach(msg => {
            $('#messages').append(`<div><b>${msg.user}</b>: ${msg.content} <i style="font-size:0.7em;color:#666;">${msg.created_at}</i></div>`);
        });
        $('#messages').scrollTop($('#messages')[0].scrollHeight);
    });
}

// Send message
function sendMessage(channelId, user, content) {
    $.post('/api/messages.php', {channel_id: channelId, user: user, content: content}, function(){
        loadMessages(channelId);
    });
}

// WebRTC functions
async function startCall() {
    localStream = await navigator.mediaDevices.getUserMedia({video:true,audio:true});
    $('#localVideo')[0].srcObject = localStream;

    peerConnection = new RTCPeerConnection({iceServers});

    localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

    peerConnection.ontrack = event => {
        $('#remoteVideo')[0].srcObject = event.streams[0];
    };

    peerConnection.onicecandidate = event => {
        if(event.candidate) {
            ws.send(JSON.stringify({type:'candidate', candidate:event.candidate}));
        }
    };

    ws = new WebSocket(signalingServerUrl);

    ws.onopen = async () => {
        console.log("Connected to signaling server");
        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        ws.send(JSON.stringify({type:'offer', offer:offer}));
        $('#startCallBtn').prop('disabled', true);
        $('#hangupCallBtn').prop('disabled', false);
    };

    ws.onmessage = async (message) => {
        const data = JSON.parse(message.data);
        if(data.type === 'offer') {
            await peerConnection.setRemoteDescription(new RTCSessionDescription(data.offer));
            const answer = await peerConnection.createAnswer();
            await peerConnection.setLocalDescription(answer);
            ws.send(JSON.stringify({type:'answer', answer:answer}));
        }
        else if(data.type === 'answer') {
            await peerConnection.setRemoteDescription(new RTCSessionDescription(data.answer));
        }
        else if(data.type === 'candidate') {
            await peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
        }
    };

    ws.onclose = () => {
        console.log("Signaling server connection closed");
    };
}

function hangUp() {
    if(peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    if(ws) {
        ws.close();
        ws = null;
    }
    if(localStream) {
        localStream.getTracks().forEach(t => t.stop());
        localStream = null;
    }
    $('#localVideo')[0].srcObject = null;
    $('#remoteVideo')[0].srcObject = null;
    $('#startCallBtn').prop('disabled', false);
    $('#hangupCallBtn').prop('disabled', true);
}

// Admin: add channel
function addChannel(name) {
    $.post('/api/channels.php', {name:name}, function(){
        loadChannels();
        $('#newChannelName').val('');
    });
}

// Admin: delete channel
function deleteChannel(id) {
    $.ajax({url: '/api/channels.php?id=' + id,
type: 'DELETE',
success: function(){
loadChannels();
if(currentChannelId === id) {
currentChannelId = null;
$('#messages').empty();
}
}
});
}

$(function(){
loadChannels();// Select channel to view messages
$('#channelsList').on('click', '.channel', function(){
    currentChannelId = parseInt($(this).data('id'));
    loadMessages(currentChannelId);
});

// Send message
$('#sendMessageBtn').click(function(){
    const msg = $('#messageInput').val().trim();
    if(!msg || !currentChannelId) return alert('Select channel and type message');
    sendMessage(currentChannelId, 'User', msg);
    $('#messageInput').val('');
});

// Admin add channel
$('#addChannelBtn').click(function(){
    const name = $('#newChannelName').val().trim();
    if(name) addChannel(name);
});

// Admin delete channel
$('#adminChannelsList').on('click', '.deleteChannelBtn', function(){
    const id = parseInt($(this).parent().data('id'));
    if(confirm('Delete channel #' + id + '?')) {
        deleteChannel(id);
    }
});

// Call buttons
$('#startCallBtn').click(startCall);
$('#hangupCallBtn').click(hangUp);

       
