/**
 * UserSignupAjaxForm is contains business logic for ajax signup validation
 * wikiaForm - instance of WikiaForm
 * inputsToValide - array of input names to be ok'ed before submission
 * submitButton - pointer to main submit button of the form
 */
var UserSignupAjaxForm = function(wikiaForm, inputsToValidate, submitButton) {
	this.wikiaForm = wikiaForm;
	this.inputsToValidate = inputsToValidate || [];
	this.submitButton = $(submitButton);
};

UserSignupAjaxForm.prototype.validateInput = function(e) {
	var el = $(e.target);
	var paramName = el.attr('name');
	var params = {
		controller: 'UserSignupSpecial',
		method: 'formValidation',
		format: 'json',
		field: paramName
	};

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

	var isInvalid = false;
	var inputsToValidate = form.inputsToValidate;
	for(var i = 0; i < inputsToValidate.length; i++) {
		if(form.wikiaForm.getInputGroup(inputsToValidate[i]).hasClass('error')) {
			isInvalid = true;
			break;
		}
	}

	if(isInvalid) {
		form.submitButton.attr('disabled', 'disabled');
	} else {
		form.submitButton.removeAttr('disabled');
	}
};