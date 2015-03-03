/* global  wgScriptPath, wgWikiaMaxNameChars, wgMinimalPasswordLength */
(function () {
	'use strict';

	/**
	 * UserSignupAjaxValidation contains business logic for ajax signup validation
	 *
	 * @param {object} options
	 * - wikiaForm: instance of WikiaForm
	 * - inputsToValide: array of input names to be ok'ed before submission
	 * - submitButton: pointer to main submit button of the form
	 * - passwordInputName: input name attribute for form's password input
	 * @constructor
	 */
	var UserSignupAjaxValidation = function (options) {
		this.wikiaForm = options.wikiaForm;
		this.inputsToValidate = options.inputsToValidate || [];
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
			paramName = $el.attr('name'),
			params = {},
			value = $el.val();

		// don't send password values to the server, validated them here in JS
		if (paramName === this.passwordInputName) {
			this.validatePassword(value);
		} else {
			params.field = paramName;
			params[paramName] = value;

			this.sendRequest(params)
				.done(this.validationHandler.bind(this, paramName));
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
			paramName = this.passwordInputName,
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

		this.validationHandler(paramName, response);
	};

	/**
	 * Call back end for validation of input where user action occurred
	 * @todo This was copied from validateInput with some added input name mapping. Clean this up in a separate ticket.
	 * @param {Event} e Browser event like input blur
	 */
	UserSignupAjaxValidation.prototype.validateMappedInput = function (e) {
		var $el = $(e.target),
			paramName = $el.attr('name'),
			params = {},
			value = $el.val(),
			mappedParamName,
			map;

		// don't send password values to the server, validated them here in JS
		if (paramName === this.passwordInputName) {
			this.validatePassword(value);
		} else {
			// back end validation expects these fields to match the user signup form, so we'll map them to those values
			// before sending.
			map = {
				'username': 'userloginext01'
			};

			mappedParamName = map[paramName] || paramName;
			params.field = mappedParamName;
			params[mappedParamName] = value;

			this.sendRequest(params)
				.done(this.validationHandler.bind(this, paramName));
		}
	};

	/**
	 * Shared AJAX helper method
	 * @param {object} data
	 * @returns {jQuery} Promise
	 */
	UserSignupAjaxValidation.prototype.sendRequest = function (data) {
		return $.nirvana.sendRequest({
			controller: 'UserSignupSpecial',
			method: 'formValidation',
			type: 'GET',
			data: data
		});
	};

	UserSignupAjaxValidation.prototype.validationHandler = function (paramName, response) {
		if (response.result === 'ok') {
			this.wikiaForm.clearInputError(paramName);
		} else {
			this.wikiaForm.showInputError(paramName, response.msg);
		}
	};

	UserSignupAjaxValidation.prototype.validateBirthdate = function (e) {
		var $el = $(e.target),
			paramName = $el.attr('name'),
			params = this.getDefaultParamsForAjax();

		if (this.deferred && typeof this.deferred.reject === 'function') {
			this.deferred.reject();
		}

		$.extend(params, {
			field: 'birthdate',
			birthyear: this.wikiaForm.inputs.birthyear.val(),
			birthmonth: this.wikiaForm.inputs.birthmonth.val(),
			birthday: this.wikiaForm.inputs.birthday.val()
		});

		this.deferred = $.post(
			wgScriptPath + '/wikia.php',
			params,
			this.validationHandler.bind(this, paramName)
		);
	};

	/**
	 * @todo User $.nivana instead
	 * @returns {{controller: string, method: string, format: string}}
	 */
	UserSignupAjaxValidation.prototype.getDefaultParamsForAjax = function () {
		return {
			controller: 'UserSignupSpecial',
			method: 'formValidation',
			format: 'json'
		};
	};

	UserSignupAjaxValidation.prototype.checkFieldsValid = function () {
		var isValid = true,
			inputsToValidate = this.inputsToValidate,
			i;

		for (i = 0; i < inputsToValidate.length; i++) {
			if (this.checkFieldEmpty(this.wikiaForm.inputs[inputsToValidate[i]]) ||
				this.wikiaForm.getInputGroup(inputsToValidate[i]).hasClass('error')) {
				isValid = false;
				break;
			}
		}

		return isValid;
	};

	UserSignupAjaxValidation.prototype.checkFieldEmpty = function (field) {
		return field && ((field.is('input') && field.val() === '') || (field.is('select') && field.val() === -1));
	};

	window.UserSignupAjaxValidation = UserSignupAjaxValidation;
})();
