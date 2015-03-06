/* global wgWikiaMaxNameChars, wgMinimalPasswordLength */
(function () {
	'use strict';

	/**
	 * UserSignupAjaxValidation contains business logic for ajax signup validation
	 *
	 * @param {object} options
	 * - wikiaForm: instance of WikiaForm
	 * - submitButton: pointer to main submit button of the form
	 * - passwordInputName: input name attribute for form's password input
	 * @constructor
	 */
	var UserSignupAjaxValidation = function (options) {
		this.wikiaForm = options.wikiaForm;
		this.submitButton = $(options.submitButton);
		this.deferred = false;
		this.passwordInputName = options.passwordInputName || 'password';
	};

	/**
	 * Call back end for validation of input where user action occurred
	 * @param {Event} e Browser event like input blur
	 */
	UserSignupAjaxValidation.prototype.validateInput = function (e) {
		var $el = $(e.target),
			data = {},
			inputName = $el.attr('name'),
			value = $el.val(),
			usernameAlias = 'userloginext01';

		// don't send password values to the server, validated them here in JS
		if (inputName === this.passwordInputName) {
			this.validatePassword(value);
		} else {
			// back end expects 'userloginext01' instead of 'username'
			if (inputName === 'username') {
				data.field = usernameAlias;
				data[usernameAlias] = value;
			} else {
				data.field = inputName;
				data[inputName] = value;
			}

			this.sendValidationRequest(data)
				.done(this.validationHandler.bind(this, inputName));
		}
	};

	/**
	 * Client side validation that mirrors server side validation for password input. (SOC-316)
	 * Validating client side reduces passwords being sent over HTTP in plain text.
	 * @param {string} password
	 */
	UserSignupAjaxValidation.prototype.validatePassword = function (password) {
		var pwLength = password.length,
			msg = '',
			inputName = this.passwordInputName,
			response = {};

		// check password isn't too short (defaults to 1 char)
		if (pwLength < wgMinimalPasswordLength) {
			msg = mw.message('userlogin-error-wrongpasswordempty').escaped();

		// check password isn't too long (defaults to 50 chars)
		} else if (pwLength > wgWikiaMaxNameChars) {
			msg = mw.message('usersignup-error-password-length').escaped();
		}

		if (msg !== '') {
			response.msg = msg;
			response.result = 'error';
		} else {
			response.result = 'ok';
		}

		this.validationHandler(inputName, response);
	};

	/**
	 * Handle birthday validation as a collection of inputs as opposed to one input.
	 * @param {Event} e Browser event like select element blur
	 */
	UserSignupAjaxValidation.prototype.validateBirthdate = function (e) {
		var $el, inputName, data;

		if (this.deferred && typeof this.deferred.reject === 'function') {
			this.deferred.reject();
		}

		$el = $(e.target);
		inputName = $el.attr('name');
		data = {
			field: 'birthdate',
			birthyear: this.wikiaForm.inputs.birthyear.val(),
			birthmonth: this.wikiaForm.inputs.birthmonth.val(),
			birthday: this.wikiaForm.inputs.birthday.val()
		};

		this.deferred = this.sendValidationRequest(data)
			.done(this.validationHandler.bind(this, inputName));
	};

	/**
	 * Apply error and success handling via WikiaForm instance
	 * @param {string} inputName Name of input to handle messaging
	 * @param {object} response Data for error/success handling
	 */
	UserSignupAjaxValidation.prototype.validationHandler = function (inputName, response) {
		if (response.result === 'ok') {
			this.wikiaForm.clearInputError(inputName);
		} else {
			this.wikiaForm.showInputError(inputName, response.msg);
		}
	};

	/**
	 * Shared AJAX helper method
	 * @param {object} data
	 * @returns {jQuery} Promise
	 */
	UserSignupAjaxValidation.prototype.sendValidationRequest = function (data) {
		return $.nirvana.sendRequest({
			controller: 'UserSignupSpecial',
			method: 'formValidation',
			type: 'GET',
			data: data
		});
	};

	window.UserSignupAjaxValidation = UserSignupAjaxValidation;
})();
