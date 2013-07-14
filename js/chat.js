var chat = {}

chat.fetchMessages = function(){
	$.ajax({
		url: 'ajax/chat.php'.
		type: 'post',
		data: { method: 'fetch'},
		success: function(data) {
			$('.chat .messages').html(data);
		}
	});
}

chat.interval = setInterval(chat.fetchMessages, 5000);
chat.fetchMessages();