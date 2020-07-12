$('#login-form-login').on('submit', function(){
	let login = $('#login').val();
	let pswd = $('#pswd').val();
	let ua = navigator.userAgent;
	$.ajax({
		url: '../handlers/login.php',
		type: 'post',
		async: true,
		data: {'login':login, 'pswd':pswd, 'ua':ua},
		success: function(data){
			if(data === "OK"){
				window.location.href = "index.html";
			}else{
				$('.sysmessage').html(data);
			}
		},
		error: function(){
			$('.sysmessage').html("<div class='error-message'>Ошибка отправки данных!</div>");
		}
	});
	return false;
});