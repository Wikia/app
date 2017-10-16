(function () {
	'use strict';

	/**
	 * WikiaForm utility functions
	 * To be used with .WikiaForm DOM elements only
	 * This code should only change the visual aesthetics of the form.
	 * DO NOT PLACE ANY BUSINESS LOGIC HERE
	 */
	var WikiaForm = function (el) {
		this.el = $(el);
		this.form = this.el.is('form') ? this.el : this.el.find('form');

		if (!this.form.length) {
			Wikia.log(
				'WikiaForm with selector "' + this.el.selector + '" doesn\'t include a form element',
				Wikia.log.levels.error,
				'WikiaForm'
			);
		}

		this.initGenericError();
		this.initGenericSuccess();
		this.setInputs();

		this.inputGroups = {};

		// handle tooltips
		this.el.find('[rel=tooltip]').tooltip();
	};

	/**
	 * Initialize generic error field which, generally sits at the top of a form as opposed
	 * to being associated with any particular input.
	 */
	WikiaForm.prototype.initGenericError = function () {
		this.genericError = this.el.find('.general-errors');
		if (this.genericError.length === 0) {
			this.el.find('fieldset')
				.prepend('<div class="input-group general-errors error"><div class="error-msg"></div></div>');
			this.genericError = this.el.find('.general-errors');
			this.genericError.hide();
			this.genericErrorMsg = this.genericError.find('.error-msg');
		}
	};

	/**
	 * Initialize generic success field which, generally sits at the top of a form as opposed
	 * to being associated with any particular input.
	 */
	WikiaForm.prototype.initGenericSuccess = function () {
		this.genericSuccess = this.el.find('.general-success');
		if (this.genericSuccess.length === 0) {
			this.el.find('fieldset')
				.prepend('<div class="input-group general-success success"><div class="success-msg"></div></div>');
			this.genericSuccess = this.el.find('.general-success');
			this.genericSuccess.hide();
			this.genericSuccessMsg = this.genericSuccess.find('.success-msg');
		}
	};

	/**
	 * Pre-cache known inputs by name
	 * Note: this doesn't work with dynamic inputs
	 */
	WikiaForm.prototype.setInputs = function () {
		var inputs, $input, i, name;

		this.inputs = {};
		inputs = this.el.find('input, select, textarea');

		for (i = 0; i < inputs.length; i++) {
			$input = $(inputs[i]);
			name = $input.attr('name');
			if (name) {
				this.inputs[name] = $input;
			}
		}
	};

	WikiaForm.prototype.showGenericError = function (msg) {
		this.genericError.show();
		this.showErrorMsg(this.genericError, msg);
	};

	WikiaForm.prototype.showGenericSuccess = function (msg) {
		this.genericSuccess.show();
		this.showSuccessMsg(this.genericSuccess, msg);
	};

	/**
	 * Gets the wrapping element of the input with the specified name. Sets is if it's not already cached.
	 * @todo Add better error handling and split into smaller functions
	 * @param {string} name
	 * @returns {jQuery|undefined}
	 */
	WikiaForm.prototype.getInputGroup = function (name) {
		var input,
			inputGroup = this.inputGroups[name]; //cache lookup

		if (!inputGroup) {
			inputGroup = this.inputs[name].closest('.input-group');
			if (!inputGroup.length) { // fallback - check if input has been dynamically added
				input = this.el.find('input[name=' + name + ']');
				if (input.length !== 0) {
					inputGroup = input.closest('.input-group');
				}
			}

			// cache if found
			if (inputGroup.length !== 0) {
				this.inputGroups[name] = inputGroup;
			}
		}

		return inputGroup;
	};

	/**
	 * Displays an error message near the input the error is associated with.
	 *
	 * @param {string} name Name attribute of the input tag (e.g. <input name="foobar"> would be "foobar")
	 * @param {string} msg Error message to display to the user
	 */
	WikiaForm.prototype.showInputError = function (name, msg) {
		var inputGroup = this.getInputGroup(name);

		if (inputGroup) {
			inputGroup.addClass('error').removeClass('success');
			this.showErrorMsg(inputGroup, msg);
		}
	};

	WikiaForm.prototype.clearInputError = function (name) {
		var inputGroup = this.getInputGroup(name);

		inputGroup.removeClass('error').addClass('success');

		this.clearErrorMsg(inputGroup);
	};

	WikiaForm.prototype.showErrorMsg = function (inputGroup, msg) {
		var errorMsg = inputGroup.find('.error-msg');
		if (!errorMsg.length) {
			errorMsg = '<div class="error-msg"></div>';
			inputGroup.append(errorMsg);
			errorMsg = inputGroup.find('.error-msg');
		}
		errorMsg.html(msg);
	};

	WikiaForm.prototype.showSuccessMsg = function (inputGroup, msg) {
		var successMsg = inputGroup.find('.success-msg');
		if (!successMsg.length) {
			successMsg = '<div class="success-msg"></div>';
			inputGroup.append(successMsg);
			successMsg = inputGroup.find('.success-msg');
		}
		successMsg.text(msg);
	};

	WikiaForm.prototype.clearErrorMsg = function (inputGroup) {
		inputGroup.find('.error-msg').remove();
	};
	WikiaForm.prototype.clearSuccessMsg = function (inputGroup) {
		inputGroup.find('.success-msg').remove();
	};

	WikiaForm.prototype.clearGenericError = function (inputGroup) {
		inputGroup.hide().find('.error-msg').remove();
	};
	WikiaForm.prototype.clearGenericSuccess = function (inputGroup) {
		inputGroup.hide().find('.success-msg').remove();
	};

	WikiaForm.prototype.clearAllInputErrors = function () {
		for (var key in this.inputGroups) {
			this.clearInputError(key);
		}
	};

	WikiaForm.prototype.disableAll = function () {
		$.each(this.inputs, function () {
			this.attr('disabled', true);
		});
	};

	window.WikiaForm = WikiaForm;
})();
