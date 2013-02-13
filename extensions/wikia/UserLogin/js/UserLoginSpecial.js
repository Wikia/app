$(function() {
	if( window.wgEnableUserLoginExt ) {
		var form = $('.UserLogin'),
			formGroup = form.find('.input-group'),
			formError = form.find('.error-msg'),
			formUserName = form.find('input[name=username]');

		$('.forgot-password').on('click', function(e) {
			formGroup.removeClass('error');
			formError.remove();
			$.nirvana.sendRequest({
				controller: 'UserLoginSpecial',
				method: 'mailPassword',
				data: {
					username: formUserName.val()
				},
				type: 'post',
				format: 'json',
				callback: function(json) {
					if(json['result'] === 'ok' || json['result'] === 'error') {
						formUserName
							.parent()
							.addClass('error')
							.find('.error-msg')
							.remove()
							.end()
							.append('<div class="error-msg">'+json['msg']+'</div>');
					}
				}
			});
			e.preventDefault();
		});
	}
});