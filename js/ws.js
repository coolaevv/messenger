function sysMessage(text){
	$('section').text(text);
}
function getMessage(text){
	let audio = new Audio();
	audio.preload = 'auto';
	audio.src = '../notice/notice_messages.mp3';
	audio.play();
	$('.messages').append(text);
	$('.messages').scrollTop(99999999999999999);
}
$(document).ready(function(){
	let host = "ws://192.168.1.209:8080/messenger/server/ws_server.php";
	let wsocket = new WebSocket(host);

	wsocket.onopen = function(event){ //Открытие соеденения с сервером
		sysMessage('Соеденение установлено!');
	}

	wsocket.onerror = function(error){ //Ошибка соеденения с сервером
		sysMessage('Сервер недоступен, повторите попытку ' + (error.message ? error.message : ""));
	}

	wsocket.onclose = function(event){
		sysMessage('Соеденение закрыто!');
	}

	wsocket.onmessage = function(event){
		if(event.data === ''){
			delete event.data;
		}else{
			getMessage(event.data);
		}
	}

	$('.send').click(function(){
		let message = $('#message').val();
		$('#message').val('');
		
		wsocket.send(message);
		
		let div_html = "<div class='message-user'><div class='text'>" + message + "</div></div>";
		if(message == ""){
			delete div_html;
		}
		else{
			$('.messages').append(div_html);
		}
		$('.messages').scrollTop(99999999999999999);
	});
});