define('vpt.models.validator', [ 'jquery' ], function( $ ) {

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
		 * @param {jQuery} $elem Form input to set the rule on
		 * @param {string} rule Rule property exactly as defined by the jQuery validator plugin
		 * @param {string|function} value Value to send to the jQuery validator rule
		 */
		setRule: function( $elem, rule, value ) {
			$elem.data( rule, value );
		},

		/*
		 * Add a rule to each element because validator can't handle array inputs by default (i.e. video_description[])
		 */
		addRules: function() {
			var $this = $( this ),
				minlength = $this.data( 'minlength' ) || 0;

			$this.rules( 'add', {
				required: true,
				minlength: minlength,
				messages: {
					required: $.msg( 'htmlform-required' ),
					// Dynamically calculate the character length in the error message as you type.
					// Note: onkeyup needs to be set to false for this to work properly
					minlength: function( len, elem ) {
						var charsToGo = minlength - $( elem ).val().length;
						return [ $.msg( 'videopagetool-description-minlength-error', len, charsToGo ) ];
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

			if( this.formIsValid() ) {
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