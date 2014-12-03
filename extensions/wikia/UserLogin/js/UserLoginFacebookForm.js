/* global UserLoginAjaxForm */

(function () {
	'use strict';

	var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {
		// login token is stored in hidden field, no need to send an extra request
		// TODO: check if this override is necessary.
		// Maybe check login token from hidden field before making the request
		retrieveLoginToken: function () {},

		// Handles existing user login via modal
		ajaxLogin: function () {
			var values = {
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				signupToken: this.inputs.logintoken.val()
			};

			// cache redirect url for after form is complete
			this.returnToUrl = this.inputs.returntourl.val();

			$.nirvana.postJson(
				'FacebookSignupController',
				'login',
				values,
				this.submitLoginHandler.bind(this)
			);
		},

		submitLoginHandler: function (json) {
			this.form.find('.error-msg').remove();
			this.form.find('.input-group').removeClass('error');
			var result = json.result,
				callback;

			if (result === 'ok') {
				window.wgUserName = json.wgUserName;
				callback = this.options.callback || '';
				if (callback && typeof callback === 'function') {
					// call with current context
					callback.bind(this, json)();
				} else {
					window.location.reload();
				}
			} else if (result === 'error') {
				window.GlobalNotification.show(json.message || $.msg('oasis-generic-error'), 'error');
			} else {
				this.submitButton.removeAttr('disabled');
				this.errorValidation(json);
			}
		}
	});

	// Expose global
	window.UserLoginFacebookForm = UserLoginFacebookForm;
})();
