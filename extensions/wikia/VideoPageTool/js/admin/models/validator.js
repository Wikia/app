/*
 * Uses jQuery Validation Plugin for validating admin forms
 * @author lizlux
 * @see http://jqueryvalidation.org/
 */

define('videopageadmin.models.validator', ['jquery'], function ($) {

	'use strict';

	function Validator(options) {
		this.$form = options.form;
		this.$fields = options.fields;
		this.init();
	}

	Validator.prototype = {
		init: function () {
			this.validator = this.$form.validate();
			this.$form.on('submit', $.proxy(this.onSubmit, this));

			// If the back end has thrown an error, run the front end validation on page load
			if ($('#vpt-form-error').length) {
				this.formIsValid();
			}
		},

		/*
		 * call submit on the DOM element to prevent retriggering the jQuery event
		 */
		onSubmit: function (e) {
			e.preventDefault();
			var $firstError;

			// only execute if method exists in context
			if (this.formIsValid && this.formIsValid()) {
				this.$form[0].submit();
				return true;
			}

			// jump back up to form box if errors are present
			$firstError = $('.error').eq(0);
			$firstError
				.closest('.form-box')
				.get(0)
				.scrollIntoView(true);

			return false;
		},

		/*
		 * This is a bit of a hack to deal with jQuery validate's inability to handle input arrays
		 * @return BOOL Is the form valid
		 */
		formIsValid: function () {
			var self = this,
				isValid = true;

			_.each(this.$fields, function (elem) {
				if (!(self.validator.element($(elem)))) {
					isValid = false;
				}
			});

			return isValid;
		},

		/*
		 * Remove any error messages and classes added to the form by the validator
		 */
		clearErrors: function () {
			this.$fields.removeClass('error').next('.error').remove();
		}
	};

	return Validator;
});
