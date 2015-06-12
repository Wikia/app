/* global UserBaseAjaxForm, UserSignupMixin */
(function () {
	'use strict';

	var FacebookFormCreateUser = function (el, options) {
		UserBaseAjaxForm.call(this, el, options);
	};

	FacebookFormCreateUser.prototype = Object.create(UserBaseAjaxForm.prototype);

	// Add common user signup mixin functions for use in this class
	UserSignupMixin.call(FacebookFormCreateUser.prototype);

	FacebookFormCreateUser.prototype.init = function () {
		UserBaseAjaxForm.prototype.init.call(this);

		// imported via UserSignupMixin
		this.initOptIn(this.wikiaForm);
		this.setCountryValue(this.wikiaForm);
	};

	/**
	 * Send ajax login request to FB controller.
	 */
	FacebookFormCreateUser.prototype.ajaxLogin = function () {
		var formData = this.wikiaForm.form.serialize();

		// cache redirect url for after form submission is complete
		this.returnToUrl = this.inputs.returntourl.val();

		$.nirvana.postJson(
			'FacebookSignupController',
			'signup',
			formData,
			this.submitLoginHandler.bind(this)
		);
	};

	/**
	 * Extends login handler callback for tracking and any additional work
	 * @param {Object} response Response object from FacebookSignupController::signup
	 */
	FacebookFormCreateUser.prototype.submitLoginHandler = function (response) {
		if (response.result === 'ok') {
			window.Wikia.Tracker.track({
				category: 'user-sign-up',
				trackingMethod: 'analytics',
				action: window.Wikia.Tracker.ACTIONS.SUCCESS,
				label: 'facebook-signup'
			});
		}

		UserBaseAjaxForm.prototype.submitLoginHandler.call(this, response);
	};

	window.FacebookFormCreateUser = FacebookFormCreateUser;
})();
