/*
 * Uses jQuery Validation Plugin for validating admin forms
 * @author lizlux
 * @see http://jqueryvalidation.org/
 */

define( 'vpt.models.validator', [ 'jquery' ], function( $ ) {

	'use strict';

	function Validator( options ) {
		this.$form = options.form;
		this.$formFields = options.formFields;
		this.init();
	}

	Validator.prototype = {
		init: function() {
			this.validator = this.$form.validate();

			this.$formFields.each( this.addRules );
			this.$form.on( 'submit', $.proxy( this.onSubmit, this ) );
		},

		/*
		 * Add a validation rule to an element.
		 *
		 * Note: this only supports maxlength for now but we can make this more versatile once we start needing
		 * more rules. Possibly add a getRule() method.
		 *
		 * @param {jQuery} $elem Form input to set the rule on
		 * @param {string} rule Rule property exactly as defined by the jQuery validator plugin
		 * @param {string|function} value Value to send to the jQuery validator rule
		 */
		setRule: function( $elem, rule, value ) {
			$elem.data( 'rule-' + rule, value );
		},

		/*
		 * Add a rule to each element because validator can't handle array inputs by default (i.e. video_description[])
		 */
		addRules: function() {
			var $this = $( this ),
				maxlength = $this.data( 'rule-maxlength' ) || false;

			$this.rules( 'add', {
				required: true,
				maxlength: maxlength,
				messages: {
					required: $.msg( 'htmlform-required' ),
					// Dynamically calculate the character length in the error message as you type.
					// Note: onkeyup needs to be set to false for this to work properly. Also, this is only used
					// in IE9 since it doesn't support the maxlength attribute on textareas
					maxlength: function( len, elem ) {
						var charsToGo =  $( elem ).val().length - maxlength;
						return [ $.msg( 'videopagetool-description-maxlength-error', len, charsToGo ) ];
					}
				},
				onkeyup: false
			});
		},

		/*
		 * call submit on the DOM element to prevent retriggering the jQuery event
		 */
		onSubmit: function( e ) {
			e.preventDefault();

			if ( this.formIsValid() ) {
				this.$form[0].submit();
			}
		},

		/*
		 * This is a bit of a hack to deal with jQuery validate's inability to handle input arrays
		 * @return BOOL Is the form valid
		 */
		formIsValid: function() {
			var that = this,
				isValid = true;

			this.$formFields.each( function() {
				if ( !( that.validator.element( $( this ) ) ) ) {
					isValid = false;
				}
			});

			return isValid;
		},

		/*
		 * Remove any error messages and classes added to the form by the validator
		 */
		clearErrors: function() {
			this.$formFields.removeClass( 'error' ).next( '.error' ).remove();
		}
	};

	return Validator;
});