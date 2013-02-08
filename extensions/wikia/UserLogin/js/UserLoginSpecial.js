$(function() {
	if( window.wgEnableUserLoginExt ) {
		/* Hyun (2013-01-24) - super ultra shitty hack to fix the problem at hand */
		/* it is almost copied and pasted code from small part of UserLoginAjaxForm */
		var form = $('.UserLogin'),
			wikiaForm = new WikiaForm(form.find('form'));
		
		$('.forgot-password').on('click.haxxor', function(e) {
			e.preventDefault();
			form.find('.input-group').removeClass('error');
			form.find('.error-msg').remove();
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'UserLoginSpecial',
				method: 'mailPassword',
				format: 'json',
				username: form.find('input[name=username]').val()
			}, function(json) {
				if(json['result'] === 'ok' || json['result'] === 'error') {
					if(json['errParam']) {
						wikiaForm.showInputError(json['errParam'], json['msg']);
					} else {
						wikiaForm.showGenericError(json['msg']);
					}
				}
			});
		});
	}
});