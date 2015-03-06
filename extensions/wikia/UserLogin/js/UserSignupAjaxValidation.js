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
		this.inputsToValidate = options.inputsToValidate || [];
		this.submitButton = $(options.submitButton);
	};

	/**
	 * Call back end for validation of input where user action occurred
	 * @param {Event} e Browser event like input blur
	 */
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

	/**
	 * Call back end for validation of input where user action occurred
	 * @todo This was copied from validateInput with some added input name mapping. Clean this up in a separate ticket.
	 * @param {Event} e Browser event like input blur
	 */
	UserSignupAjaxValidation.prototype.validateMappedInput = function (e) {
		var el = $(e.target),
			paramName = el.attr('name'),
			params = this.getDefaultParamsForAjax(),
			mappedParamName,
			map;

		// back end validation expects these fields to match the user signup form, so we'll map them to those values
		// before sending.
		map = {
			'username': 'userloginext01',
			'password': 'userloginext02'
		};

		mappedParamName = map[paramName] || paramName;
		params.field = mappedParamName;
		params[mappedParamName] = el.val();

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

		if (UserSignup.deferred && typeof UserSignup.deferred.reject === 'function') {
			UserSignup.deferred.reject();
		}

		$.extend(params, {
			field: 'birthdate',
			birthyear: this.wikiaForm.inputs.birthyear.val(),
			birthmonth: this.wikiaForm.inputs.birthmonth.val(),
			birthday: this.wikiaForm.inputs.birthday.val()
		});

		UserSignup.deferred = $.post(
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
