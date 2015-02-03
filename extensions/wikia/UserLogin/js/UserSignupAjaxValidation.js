/* global  wgScriptPath, UserSignup */
(function () {
	'use strict';

	/**
	 * UserSignupAjaxValidation contains business logic for ajax signup validation
	 *
	 * @param {object} options
	 * - wikiaForm: instance of WikiaForm
	 * - inputsToValide: array of input names to be ok'ed before submission
	 * - submitButton: pointer to main submit button of the form
	 * @constructor
	 */
	var UserSignupAjaxValidation = function (options) {
		this.wikiaForm = options.wikiaForm;
		this.notEmptyFields = options.notEmptyFields || [];
		this.captchaField = options.captchaField || '';
		this.submitButton = $(options.submitButton);

		// used for tracking ajax calls in progress
		this.deferred = false;
	};

	UserSignupAjaxValidation.prototype.validateInput = function (e) {
		var el = $(e.target),
			paramName = el.attr('name'),
			params = this.getDefaultParamsForAjax();

		params.field = paramName;
		params[paramName] = el.val();

		$.get(
			wgScriptPath + '/wikia.php',
			params,
			this.validationHandler.bind(this, paramName)
		);
	};

	UserSignupAjaxValidation.prototype.validationHandler = function (paramName, response) {
		if (response.result === 'ok') {
			this.wikiaForm.clearInputError(paramName);
		} else {
			this.wikiaForm.showInputError(paramName, response.msg);
		}
	};

	UserSignupAjaxValidation.prototype.validateBirthdate = function (e) {
		var el = $(e.target),
			paramName = el.attr('name'),
			params = this.getDefaultParamsForAjax();

		if (this.deferred && typeof this.deferred.reject === 'function') {
			UserSignup.deferred.reject();
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
			method: 'formAjaxValidation',
			format: 'json'
		};
	};

	UserSignupAjaxValidation.prototype.checkFieldsValid = function () {
		var isValid = true,
			inputsToValidate = this.notEmptyFields,
			i;

		for (i = 0; i < inputsToValidate.length; i++) {
			if (this.checkFieldEmpty(this.wikiaForm.inputs[inputsToValidate[i]]) ||
				this.wikiaForm.getInputGroup(inputsToValidate[i]).hasClass('error')) {
				isValid = false;
				break;
			}
		}

		if (this.captchaField && this.checkFieldEmpty(this.wikiaForm.inputs[this.captchaField])) {
			isValid = false;
		}

		return isValid;
	};

	UserSignupAjaxValidation.prototype.checkFieldEmpty = function (field) {
		return field && ((field.is('input') && field.val() === '') || (field.is('select') && field.val() === -1));
	};

	window.UserSignupAjaxValidation = UserSignupAjaxValidation;
})();
