define( 'vpt.views.edit', [
	'jquery'
], function( $ ) {

	function VPTEdit() {
		this.$form = $( '.vpt-form' );
		this.validator = this.$form.validate({debug:true});
		this.$formFields = this.$form.find( '.video_description, .video_display_title' ); // TODO: add hidden input for VET
		this.init();
	}

	VPTEdit.prototype = {
		init: function() {
			this.initValidate();
			this.initReset();
			this.$form.switcher({
				boxes: '.form-box',
				up: '.nav-up',
				down: '.nav-down'
			});
		},
		initValidate: function() {
			var that = this;

			// add a rule to each element because validator can't handle array inputs by default (i.e. video_description[])
			this.$formFields.each( function() {
				$( this ).rules( "add", {
					required: true,
					messages: {
						required: $.msg( 'htmlform-required' )
					}
				});
			});

			this.$form.on( 'submit', function() {
				that.$formFields.each( function() {
					that.validator.element( $(this) )
				});
			});
		},
		initReset: function() {
			var that = this;

			this.$form.find( '.reset' ).on( 'click', function(e) {
				e.preventDefault();

				$.confirm({
					title: $.msg( 'videopagetool-confirm-clear-title' ),
					content: $.msg( 'videopagetool-confirm-clear-message' ),
					onOk: function() {
						// Clear all form input values
						that.$form[0].reset();
						// TODO: Clear all error messages as well
					},
					width: 700
				});

			});
		}
	};

	return VPTEdit;
});

require(['vpt.views.edit'], function(EditView) {
	$(function() {
		new EditView();
	});
});
