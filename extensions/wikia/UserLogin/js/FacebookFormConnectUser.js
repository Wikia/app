/* global UserBaseAjaxForm */
(function () {
	'use strict';

	var FacebookFormConnectUser = function (el, options) {
		UserBaseAjaxForm.call(this, el, options);
	};

	FacebookFormConnectUser.prototype = Object.create(UserBaseAjaxForm.prototype);

	/**
	 * Handles existing user login via modal
	 */
	FacebookFormConnectUser.prototype.ajaxLogin = function () {
		var formData = this.wikiaForm.form.serialize();

		// cache redirect url for after form is complete
		this.returnToUrl = this.inputs.returntourl.val();

		$.nirvana.postJson(
			'FacebookSignupController',
			'login',
			formData,
			this.submitLoginHandler.bind(this)
		);
	};

	// Expose global
	window.FacebookFormConnectUser = FacebookFormConnectUser;
})();
