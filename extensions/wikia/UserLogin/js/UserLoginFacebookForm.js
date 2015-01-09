/* global UserLoginAjaxForm */

(function () {
	'use strict';

	var UserLoginFacebookForm = $.createClass(UserLoginAjaxForm, {
		// login token is stored in hidden field, no need to send an extra request
		retrieveLoginToken: function () {},

		// Handles existing user login via modal
		ajaxLogin: function () {
			var values = {
				username: this.inputs.username.val(),
				password: this.inputs.password.val(),
				signupToken: this.inputs.loginToken.val()
			};

			// cache redirect url for after form is complete
			this.returnToUrl = this.inputs.returntourl.val();

			$.nirvana.postJson(
				'FacebookSignupController',
				'login',
				values,
				this.submitLoginHandler.bind(this)
			);
		}
	});

	// Expose global
	window.UserLoginFacebookForm = UserLoginFacebookForm;
})();
