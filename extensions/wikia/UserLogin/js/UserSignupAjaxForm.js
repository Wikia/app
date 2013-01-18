/**
 * UserSignupAjaxForm is contains business logic for ajax signup validation
 * wikiaForm - instance of WikiaForm
 * inputsToValide - array of input names to be ok'ed before submission
 * submitButton - pointer to main submit button of the form
 */
var UserSignupAjaxForm = function(wikiaForm, inputsToValidate, submitButton, notEmptyFields) {
	this.wikiaForm = wikiaForm;
	this.inputsToValidate = inputsToValidate || [];
	this.notEmptyFields = notEmptyFields || [];
	this.submitButton = $(submitButton);

	this.activateSubmit();
};

UserSignupAjaxForm.prototype.validateInput = function(e) {
	var el = $(e.target);
	var paramName = el.attr('name');
	var params = this.getDefaultParamsForAjax();
	params['field'] = paramName;
	params[paramName] = el.val();

	var proxyObj = {
		'paramName': paramName,
		'form': this
	};

	$.post(wgScriptPath + '/wikia.php', params, $.proxy(this.validationHandler, proxyObj));
};

UserSignupAjaxForm.prototype.validationHandler = function(res) {
	var paramName = this.paramName;
	var form = this.form;	// instance of UserSignupAjaxForm
	if(res['result'] === 'ok') {
		form.wikiaForm.clearInputError(this.paramName);
	} else {
		form.wikiaForm.showInputError(this.paramName, res['msg']);
	}

	this.form.activateSubmit();
};

UserSignupAjaxForm.prototype.validateBirthdate = function(e) {
	var el = $(e.target);
	var proxyObj = {'paramName':el.attr('name'), 'form': this};
	if(UserSignup.deferred && typeof UserSignup.deferred.reject === 'function') {
		UserSignup.deferred.reject();
	}

	var params = this.getDefaultParamsForAjax();
	params = $.extend(params, {
		field: 'birthdate',
		birthyear: this.wikiaForm.inputs['birthyear'].val(),
		birthmonth: this.wikiaForm.inputs['birthmonth'].val(),
		birthday: this.wikiaForm.inputs['birthday'].val()
	});

	UserSignup.deferred = $.post(
		wgScriptPath + '/wikia.php',
		params,
		$.proxy(this.validationHandler, proxyObj)
	);
};

UserSignupAjaxForm.prototype.getDefaultParamsForAjax = function() {
	return {
		controller: 'UserSignupSpecial',
		method: 'formValidation',
		format: 'json'
	};
};

UserSignupAjaxForm.prototype.checkFieldsValid = function() {
	var isInvalid = false;
	var inputsToValidate = this.notEmptyFields;

	for(var i = 0; i < inputsToValidate.length; i++) {
		if(this.checkFieldEmpty(this.wikiaForm.inputs[inputsToValidate[i]])
			|| this.wikiaForm.getInputGroup(inputsToValidate[i]).hasClass('error')) {
			isInvalid = true;
			break;
		}
	}
	return isInvalid;
};

UserSignupAjaxForm.prototype.checkFieldEmpty = function(field) {
	return (field.is('input') && field.val() == '') || (field.is('select') && field.val() == -1);
};

UserSignupAjaxForm.prototype.activateSubmit = function() {
	var isInvalid = this.checkFieldsValid();
	if(isInvalid) {
		this.submitButton.attr('disabled', 'disabled');
	} else {
		this.submitButton.removeAttr('disabled');
	}
};