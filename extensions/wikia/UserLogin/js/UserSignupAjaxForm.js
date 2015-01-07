/* global  wgScriptPath, UserSignup */

/**
 * UserSignupAjaxForm is contains business logic for ajax signup validation
 * wikiaForm - instance of WikiaForm
 * inputsToValide - array of input names to be ok'ed before submission
 * submitButton - pointer to main submit button of the form
 */
var UserSignupAjaxForm = function (wikiaForm, inputsToValidate, submitButton, notEmptyFields, captchaField) {
	'use strict';

	this.wikiaForm = wikiaForm;
	this.inputsToValidate = inputsToValidate || [];
	this.notEmptyFields = notEmptyFields || [];
	this.captchaField = captchaField || '';
	this.submitButton = $(submitButton);

	this.activateSubmit();
};

UserSignupAjaxForm.prototype.validateInput = function (e) {
	'use strict';

	var el = $(e.target),
		paramName = el.attr('name'),
		params = this.getDefaultParamsForAjax(),
		proxyObj;

	params.field = paramName;
	params[paramName] = el.val();

	proxyObj = {
		'paramName': paramName,
		'form': this
	};

	$.get(wgScriptPath + '/wikia.php', params, $.proxy(this.validationHandler, proxyObj));
};

UserSignupAjaxForm.prototype.validationHandler = function (res) {
	'use strict';

	var form = this.form;	// instance of UserSignupAjaxForm
	if (res.result === 'ok') {
		form.wikiaForm.clearInputError(this.paramName);
	} else {
		form.wikiaForm.showInputError(this.paramName, res.msg);
	}

	this.form.activateSubmit();
};

UserSignupAjaxForm.prototype.validateBirthdate = function (e) {
	'use strict';

	var el = $(e.target),
		proxyObj = {'paramName':el.attr('name'), 'form': this},
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
		$.proxy(this.validationHandler, proxyObj)
	);
};

UserSignupAjaxForm.prototype.getDefaultParamsForAjax = function () {
	'use strict';

	return {
		controller: 'UserSignupSpecial',
		method: 'formValidation',
		format: 'json'
	};
};

UserSignupAjaxForm.prototype.checkFieldsValid = function () {
	'use strict';

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

UserSignupAjaxForm.prototype.checkFieldEmpty = function (field) {
	'use strict';

	return field && ((field.is('input') && field.val() === '') || (field.is('select') && field.val() === -1));
};

UserSignupAjaxForm.prototype.activateSubmit = function () {
	'use strict';

	var isvalid = this.checkFieldsValid();
	if (isvalid) {
		this.submitButton.removeAttr('disabled');
	} else {
		this.submitButton.attr('disabled', 'disabled');
	}
};
