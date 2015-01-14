/* global UserBaseAjaxForm */
(function () {
	'use strict';

	var FacebookFormCreateUser = function (el, options) {
		UserBaseAjaxForm.call(this, el, options);
	};

	FacebookFormCreateUser.prototype = Object.create(UserBaseAjaxForm.prototype);

	FacebookFormCreateUser.prototype.init = function () {
		UserBaseAjaxForm.prototype.init.call(this);
		this.initOptIn();
		this.setCountryValue();
	};

	/**
	 * Send ajax login request to FB controller. Overrides parent method.
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
				trackingMethod: 'both',
				action: window.Wikia.Tracker.ACTIONS.SUCCESS,
				label: 'facebook-signup'
			});
		}

		UserBaseAjaxForm.prototype.submitLoginHandler.call(this, response);
	};

	/**
	 * Handle marketing email opt-in for different locales
	 * @todo: See if we can share this with UserSignup.js
	 */
	FacebookFormCreateUser.prototype.initOptIn = function () {
		var self = this;

		require(['usersignup.marketingOptIn'], function (optIn) {
			optIn.init(self.wikiaForm);
		});
	};
	/**
	 * Send country code upon signup
	 * @todo: See if we can share this with UserSignup.js
	 */
	FacebookFormCreateUser.prototype.setCountryValue = function () {
		var country = Wikia.geo.getCountryCode();
		this.wikiaForm.inputs.wpRegistrationCountry.val(country);
	};

	window.FacebookFormCreateUser = FacebookFormCreateUser;
})();
