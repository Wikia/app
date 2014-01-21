/*
 * Uses jQuery Validation Plugin for validating admin forms
 * @author lizlux
 * @see http://jqueryvalidation.org/
 */

define( 'videopageadmin.models.validator', [ 'jquery' ], function( $ ) {

	'use strict';

	function Validator( options ) {
		this.$form = options.form;
		this.$fields = options.fields;
		this.init();
	}

	Validator.prototype = {
		init: function() {
			this.validator = this.$form.validate({debug:true});
			this.$form.on( 'submit', $.proxy( this.onSubmit, this ) );

			// If the back end has thrown an error, run the front end validation on page load
			if( $( '#vpt-form-error' ).length ) {
				this.formIsValid();
			}
		},

		/*
		 * call submit on the DOM element to prevent retriggering the jQuery event
		 */
		onSubmit: function() {
			// only execute if method exists in context
			if ( this.formIsValid && this.formIsValid() ) {
				this.$form[0].submit();
				return true;
			}

			return false;
		},

		/*
		 * This is a bit of a hack to deal with jQuery validate's inability to handle input arrays
		 * @return BOOL Is the form valid
		 */
		formIsValid: function() {
			var self = this,
				isValid = true;

			this.$fields.each( function() {
				if ( !( self.validator.element( $( this ) ) ) ) {
					isValid = false;
				}
			} );

			return isValid;
		},

		/*
		 * Remove any error messages and classes added to the form by the validator
		 */
		clearErrors: function() {
			this.$fields.removeClass( 'error' ).next( '.error' ).remove();
		}
	};

	return Validator;
} );
