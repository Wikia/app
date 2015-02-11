/* global UserBaseAjaxForm, UserSignupMixin, UserSignupAjaxValidation */
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

		this.setupAjaxValidation();
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

	FacebookFormCreateUser.prototype.setupAjaxValidation = function () {
		// userloginext0* are spam prevention names for username and password
		var inputsToValidate = ['userloginext01', 'userloginext02'],
			inputs = this.wikiaForm.inputs;

		if (inputs.email) {
			inputsToValidate.push('email');
		}

		this.validator = new UserSignupAjaxValidation({
			wikiaForm: this.wikiaForm,
			submitButton: inputs.submit,
			inputsToValidate: inputsToValidate
		});

		inputs.userloginext01
			.add(inputs.email)
			.add(inputs.userloginext02)
			.on('blur', this.validator.validateInput.bind(this.validator));
	};

	window.FacebookFormCreateUser = FacebookFormCreateUser;
})();
