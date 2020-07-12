document.onkeypress = function (event) {
	e = event || window.event;
	if (e.keyCode == 13) {
		$('#search').blur();
		$('#logo').hide();
		$('#load').fadeIn(200);
		let value = $('#search').val();
		$.ajax({
			url: '../handlers/search_contacts.php',
			type: 'post',
			cache: 'true',
			data: {'value':value},
			success: function(data){
				$('.contacts').html(data);
				$('.add_in_friends').click(function(){
					let preloaderImg = '<img src="http://socket/img/preloader.gif">';
					$(this).html(preloaderImg);
					$(this).addClass('del');
					$(this).removeClass('add_in_friends');
					let friend = $(this).prev('.email').text();
					let id = $(this).attr('data');
					console.log(id);
					$.ajax({
						url: '../handlers/add_friends.php',
						type: 'post',
						cashe: 'true',
						data: {'friend':friend, 'id':id},
						success: function(data){
							if(data == '0'){
								$(this).text('Удалить уз контактов');
								$('.del').click(function(){
									let preloaderImg = '<img src="http://socket/img/preloader.gif">';
									$(this).html(preloaderImg);
									$(this).addClass('add_in_friends');
									$(this).removeClass('del');
									let friend = $(this).prev('.email').text();
									$.ajax({
										url: '../handlers/del_friend.php',
										type: 'post',
										data: {'friend':friend},
										success: function(data){
											$('.add_in_friends').text('Добавить в контакты');
										},
										error: function(){

										}
									});
								});
							}else{
								$('.del').text(data);
							}
						},
						error: function(){
							$('.add_in_friends').text('Неизвестная ошибка');
						}
					});
				});
			},
			error: function(){
				console.log('Error');
			}
		});
	}
}