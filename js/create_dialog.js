$('.contact').click(function(){
	let opt = $(this).text();
	$('section').text(opt);
	$('.messages>div').hide();
	let id = $(this).attr('data');
	$('#message').attr('data', id);
	$.ajax({
		url: '../handlers/create_dialog.php',
		type: 'post',
		async: 'true',
		cashe: 'false',
		data: {'id':id},
		success: function(data){
			$('.messages').html(data);
			//$('.messages').scrollTop(99999999999999999);
			//console.log(data);
		},
		error: function(){
			console.log('error');
		}
	});
	return false;
});


$('.send').click(function(){
	let id = $('#message').attr('data');
	let message = $('#message').val();
	if(id === ""){
		alert('Выберите собеседника!');
	}else{
		$.ajax({
			url: '../handlers/send_txt.php',
			type: 'post',
			data: {'id':id, 'message':message},
			success: function(data){
				//$('.messages').append(data);
				//$('.messages').val();
				console.log(data)
			},
			error: function(){
	    		alert('Ошибка передачи данных!');
	    	}
		});
	}
});

$('#file').change(function send_file(){
	let file = $('#file').prop('files')[0].name;
	$('.files-send').html('<div class="file-name">' + file + '<div id="close_file"></div></div>');
	$('#close_file').click(function(){
		$('.file-name').hide();
	})
});

$('.send').click(function(){
	let file_data = $('#file').prop('files')[0];
    let form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
    	url: '../handlers/send_file.php',
    	type: 'post',
    	cache: false,
        dataType: 'text',
        processData: false,
        contentType: false,
    	data: form_data,
    	success: function(data){
    		$('.messages').append(data);
    		$('#file').val('');
    		$('.file-name').hide();
    	},
    	error: function(){
    		alert('Ошибка передачи данных!');
    	}
    });
});
$('.contact').click(function(){
	if(document.body.clientWidth < 700){
		$('.contact-list').css('margin-top', '-92vh');
		$('.messages').css("overflow-y","scroll");
		$('.messages').scrollTop(9999999999999999999999999);
	}
});
$('section').click(function(){
	if(document.body.clientWidth < 700){
		$('.contact-list').css('margin-top', '0vh');
	}
});