/**
 * WikiaForm utility functions
 * To be used with .WikiaForm DOM elements only
 * This code should only change the visual aesthetics of the form.
 * DO NOT PLACE ANY BUSINESS LOGIC HERE
 *
 * TODO: refactor to Wikia.Form
 */
var WikiaForm = function(el) {
	this.el = $(el);

	// initialize genericError field
	this.genericError = this.el.find('.general-errors');
	if(this.genericError.length == 0) {
		this.el.find('fieldset').prepend('<div class="input-group general-errors error"><div class="error-msg"></div></div>');
		this.genericError = this.el.find('.general-errors');
		this.genericError.hide();
		this.genericErrorMsg = this.genericError.find('.error-msg');
	}

	// initialize genericSuccess field
	this.genericSuccess = this.el.find('.general-success');
	if(this.genericSuccess.length == 0) {
		this.el.find('fieldset').prepend('<div class="input-group general-success success"><div class="success-msg"></div></div>');
		this.genericSuccess = this.el.find('.general-success');
		this.genericSuccess.hide();
		this.genericSuccessMsg = this.genericSuccess.find('.success-msg');
	}


	// pre-cache known inputs by name (this could potentially cause a bug if the input is dynamic)
	this.inputs = {};
	var inputs = this.el.find('input, select, textarea');
	for(var i = 0; i < inputs.length; i++) {
		var input = $(inputs[i]),
			name = input.attr('name');
		if(name) {
			this.inputs[name] = input;
		}
	}

	this.inputGroups = {};

	// handle tooltips
	this.el.find('[rel=tooltip]').tooltip();
};

WikiaForm.prototype.showGenericError = function(msg) {
	this.genericError.show();
	this.showErrorMsg(this.genericError, msg);
};

WikiaForm.prototype.showGenericSuccess = function(msg) {
	this.genericSuccess.show();
	this.showSuccessMsg(this.genericSuccess, msg);
};

WikiaForm.prototype.getInputGroup = function(paramName) {
	var inputGroup = this.inputGroups[paramName]; //cache lookup
	if(!inputGroup) {
		inputGroup = this.inputs[paramName].closest('.input-group');
		if(!inputGroup.length !== 0) {	// fallback - check if input has been dynamically added
			var input = this.el.find('input[name=' + paramName + ']');
			if(input.length !== 0) {
				inputGroup = input.closest('.input-group');
			}
		}

		// cache if found
		if(inputGroup.length !== 0) {
			this.inputGroups[paramName] = inputGroup;
		}
	}

	return inputGroup;
};

/**
 * paramName - name attribute of the input tag (e.g. <input name="foobar"> would be "foobar")
 * msg - msg to display
 */
WikiaForm.prototype.showInputError = function(paramName, msg) {
	var inputGroup = this.getInputGroup(paramName);

	if(inputGroup) {
		inputGroup.addClass('error').removeClass('success');
		this.showErrorMsg(inputGroup, msg);
	}
};

WikiaForm.prototype.clearInputError = function(paramName) {
	var inputGroup = this.getInputGroup(paramName);

	inputGroup.removeClass('error').addClass('success');

	this.clearErrorMsg(inputGroup);
};

WikiaForm.prototype.showErrorMsg = function(inputGroup, msg) {
	var errorMsg = inputGroup.find('.error-msg');
	if(!errorMsg.length) {
		errorMsg = '<div class="error-msg"></div>';
		inputGroup.append(errorMsg);
		errorMsg = inputGroup.find('.error-msg');
	}
	errorMsg.html(msg);
};

WikiaForm.prototype.showSuccessMsg = function(inputGroup, msg) {
	var successMsg = inputGroup.find('.success-msg');
	if(!successMsg.length) {
		successMsg = '<div class="success-msg"></div>';
		inputGroup.append(successMsg);
		successMsg = inputGroup.find('.success-msg');
	}
	successMsg.text(msg);
};


WikiaForm.prototype.clearErrorMsg = function(inputGroup) {
	inputGroup.find('.error-msg').remove();
};
WikiaForm.prototype.clearSuccessMsg = function(inputGroup) {
	inputGroup.find('.success-msg').remove();
};

WikiaForm.prototype.clearGenericError = function(inputGroup) {
	inputGroup.hide().find('.error-msg').remove();
};
WikiaForm.prototype.clearGenericSuccess = function(inputGroup) {
	inputGroup.hide().find('.success-msg').remove();
};

WikiaForm.prototype.clearAllInputErrors = function() {
	for (var key in this.inputGroups) {
		this.clearInputError(key);
	}
};
