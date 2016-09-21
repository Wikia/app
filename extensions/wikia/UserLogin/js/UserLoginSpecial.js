$(function() {
	var form = $('.UserLogin'),
		formGroup = form.find('.input-group'),
		wikiaForm = new WikiaForm(form.find('form')),
		formError = form.find('.error-msg'),
		formGeneralError = form.find('.general-errors'),
		formGeneralErrorMsg = null,
		formUserName = form.find('input[name=username]'),
		formLoginToken = form.find('input[name=loginToken]');

	$('.forgot-password').on('click', function(e) {
		formGroup.removeClass('error');
		formError.remove();
		$.nirvana.sendRequest({
			controller: 'UserLoginSpecial',
			method: 'mailPassword',
			data: {
				username: formUserName.val(),
				token: formLoginToken.val()
			},
			type: 'post',
			format: 'json',
			callback: function(json) {
				formGeneralErrorMsg = formGeneralError.find('.error-msg');
				if(json['result'] === 'error') {
					formUserName
						.parent()
						.addClass('error')
						.find('.error-msg')
						.remove()
						.end()
						.append('<div class="error-msg">'+json['msg']+'</div>');
					formGeneralErrorMsg.html('');
				} else if (json['result'] === 'ok') {
					formGeneralError.removeClass('error');
					formUserName
						.parent()
						.find('.error-msg')
						.remove();
					wikiaForm.showGenericError(json['msg']);
				}
			}
		});
		e.preventDefault();
	});
});
