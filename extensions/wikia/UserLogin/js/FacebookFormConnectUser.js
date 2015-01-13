/* global UserLoginAjaxForm */

(function () {
	'use strict';

	var FacebookFormConnectUser = $.createClass(UserLoginAjaxForm, {
		// login token is stored in hidden field, no need to send an extra request
		retrieveLoginToken: function () {},

		// Handles existing user login via modal
		ajaxLogin: function () {
			var formData = this.wikiaForm.form.serialize();

			// cache redirect url for after form is complete
			this.returnToUrl = this.inputs.returntourl.val();

			$.nirvana.postJson(
				'FacebookSignupController',
				'login',
				formData,
				this.submitLoginHandler.bind(this)
			);
		}
	});

	// Expose global
	window.FacebookFormConnectUser = FacebookFormConnectUser;
})();
