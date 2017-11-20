function parseUserData(data) {
    var name = data.name;
    var profile_pic = data.profile;
    var id = data.id;
    var last_message =data.last_message;
    console.log('name => ' + name + ' profile_pic => ' + profile_pic + ' id => ' + id);
    var content = '' +
        '<li class="clearfix">' +
        '<div id="' + id + '" style="cursor:pointer" onclick="openUserTab(this.id)" class="item">' +
        '<img class="profile-size round-50p center-cropped" src="' + profile_pic + '" alt="' + name + '"/>' +
        '<div class="about">' +
        '<div class="name">' + name + '</div>' +
        //'<div class="status">' + '<i class="fa fa-circle online"></i> '+last_message        + '</div>' +
        '</div>' +
        '</div>' +
        '</li>';

    $('#people-list-content').append(content);
}
function load_users() {
    resetChatHeader();
    $.get("users/", function (data, status) {
        console.log(JSON.stringify(data));
        var usersObj = JSON.parse(JSON.stringify(data));
        for (var i = 0; i < usersObj.length; i++) {
            parseUserData(data[i])
        }
    });
}
function resetUserList() {
    $('#people-list-content').innerHTML('');
}
function resetHistory() {
    resetChatHeader();
    resetChats()
}
function openUserTab(clicked_id) {


    resetHistory();
    $.get("user/" + clicked_id + "/messages", function (data, status) {
        console.log(JSON.stringify(data));
        var messageDate = JSON.parse(JSON.stringify(data));
        var name = messageDate.name;
        var profile = messageDate.profile_pic;
        var messages = messageDate.messages;
        setChatHeader(name, profile);
        setChats(messages);
    });
}
function setChatHeader(name, profile_url) {
    var content = '<img class="profile-size round-50p center-cropped"  src="' + profile_url + '" alt="avatar"/> ' +
        '<div class="chat-about"> <div class="chat-with">Chat with ' + name + '</div>' +
        // ' <div class="chat-num-messages">already 1 902 messages</div>' +
        ' </div> ' +
        '<i class="fa fa-star"></i>';

    var $chat = $('#chat-header');
    $chat.html(content);
}
function resetChatHeader() {
    var $chat = $('#chat-header');
    $chat.html('');
    var content = '<div class="round-50p" style="height:55px;width: 55px;display: inline;"></div>' +
        ' <div class="chat-about">' +
        ' <div class="chat-with">.</div> <div class="chat-num-messages">.</div> </div>'
    $chat.html(content);
}
function resetChats() {
    $('#chat-history-content').html('')
}
function setChats(data) {
    for (var i = 0; i < data.length; i++) {
        var message = data[i];
        var status = message.status;
        var content = '';
        if (status === 'received') {
            content = receivedChatBoxTemplate(message);
        } else {
            content = sentChatBoxTemplate(message);
        }
        $('#chat-history-content').append(content)
    }
}
function receivedChatBoxTemplate(data) {
    var message = data.message;
    var time = data.time;

    var d = new Date(time);
    return '<li> ' +
        '<div class="message-data">' +
        ' <span class="message-data-name">' +
        '<i class="fa fa-circle online"></i></span> ' +
        '<span class="message-data-time">' + time + '</span> ' +
        '</div> <div class="message my-message">' + message + '</div> ' +
        '</li>';
}
function sentChatBoxTemplate(data) {

    var message = data.message;
    var time = data.time;
    var d = new Date(time);

    console.log(d);
    return '<li class="clearfix">' +
        ' <div class="message-data align-right"> ' +
        '<span class="message-data-time">' + time + '</span> &nbsp; &nbsp;' +
        ' <span class="message-data-name"></span> <i class="fa fa-circle me"></i> ' +
        '</div> <div class="message other-message float-right">' + message + '</div> ' +
        '</li>';
}


$(document).ready(function () {
    load_users();
});