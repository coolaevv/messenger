$('#form-reg').on('submit', function(){
	let name = $('#name').val();
	let surname = $('#surname').val();
	let email = $('#email').val();
	let pswd_1 = $('#pswd-1').val();
	let pswd_2 = $('#pswd-2').val();
	let ua = navigator.userAgent;
	console.log(name)
	console.log(surname)
	console.log(email)
	console.log(pswd_1)
	console.log(pswd_2)
	console.log(ua)
	if(name != "" && surname != "" && email != "" && pswd_1 != "" && pswd_2 != ""){
		if($('#snopd').is(':checked')){
			let number_symbol = $("#pswd-1").val().length;
			if(number_symbol <= 9){
				$('.sysmessages').html("<div class='error-message'>Пароль должен быть длиной не менее 10 символов</div>");
			}else{
				if(pswd_1 == pswd_2){
					$.ajax({
						url: '../handlers/reg.php',
						type: 'post',
						async: true,
						cashe: 'false',
						data: {
							'name': name,
							'surname': surname,
							'email': email,
							'pswd': pswd_1,
							'ua':ua
						},
						success: function(data){
							$('.sysmessages').html(data);
						},
						error: function(){
							console.log('Error');
						}
					});
				}else{
					$('.sysmessages').html("<div class='error-message'>Пароли не совпадают!</div>");
				}
			}
		}else{
			$('.sysmessages').html("<div class='error-message'>Вы не согласились с условиями пользования</div>");
		}
	}else{
		let value = {'0':'имя', '1':'фамилию', '2':'E-Mail', '3':'пароль', '4':'повторённый пароль'};
		let array = {'0':'name', '1':'surname', '2':'email', '3':'pswd-1', '4':'pswd-2'};
		let array_data = [name, surname, email, pswd_1, pswd_2];
		for(let i = 0; i < array_data.length; i++){
			if(array_data[i] == ""){
				$('#' + array[i] + '').css('color', 'red');
				$('#' + array[i] + '').focus(function(){
					$('#' + array[i] + '').css('color', 'black');
				});
				$('#' + array[i] + '').attr("placeholder", "Введите " + value[i]);
			}
		}
	}
	return false;
});
$("#email").on("keypress", function(e) {
	let char = /["a-zA-Z0-9_@_.]/;
	let val = String.fromCharCode(e.which);
	let test = char.test(val);
	$('#email').css("color", "black");
	if(!test){
		$('#email').css("color", "red");
		$('#email').val("");
		$('#email').attr("placeholder", "Разрешены только латинские символы!");
		return false;
	}
});