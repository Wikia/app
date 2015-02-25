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

		this.controller = 'UserSignupSpecial';
		this.method = 'formAjaxValidation';

		// used for tracking ajax calls in progress
		this.deferred = false;
	};

	UserSignupAjaxValidation.prototype.validateInput = function (e) {
		var el = $(e.target),
			paramName = el.attr('name'),
			params = {
				field: paramName
			};

		params[paramName] = el.val();

		this.deferred = $.nirvana.sendRequest({
			controller: this.controller,
			method: this.method,
			type: 'GET',
			data: params,
			callback: this.validationHandler.bind(this, paramName)
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
		var el = $(e.target),
			paramName = el.attr('name'),
			params;

		if (this.deferred && typeof this.deferred.reject === 'function') {
			this.deferred.reject();
		}

		params = {
			field: 'birthdate',
			birthyear: this.wikiaForm.inputs.birthyear.val(),
			birthmonth: this.wikiaForm.inputs.birthmonth.val(),
			birthday: this.wikiaForm.inputs.birthday.val()
		};

		this.deferred = $.nirvana.sendRequest({
			controller: this.controller,
			method: this.method,
			type: 'GET',
			data: params,
			callback: this.validationHandler.bind(this, paramName)
		});
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
