// TODO: split out functionality like featured video validation into it's own module once we have a better idea of
// what other JS features we're going to need.  For now, everything is in this edit.js file

define( 'vpt.views.edit', [
	'jquery',
	'vpt.models.validator'
], function( $, Validator ) {

	'use strict';

	var VPTEdit = function() {
		this.$form = $( '.vpt-form' );
		this.$submit = $( '#feature-videos-submit' );
		// all elements to be validated - jQuery validate doesn't support arrays of form names inputs like "names[]" :(
		this.$formFields = this.$form.find( '.description, .display-title, .video-key' );
		this.init();
	};

	VPTEdit.prototype = {
		init: function() {
			this.initValidator();
			this.initReset();
			this.initSwitcher();
			this.initAddVideo();
		},
		initAddVideo: function() {
			this.$form.find( '.add-video-button' ).each( function() {
				var $this = $( this ),
					$box = $this.closest( '.form-box' ),
					$videoKeyInput = $this.siblings( '.video-key' ),
					$videoTitle = $this.siblings( '.video-title' ),
					$displayTitleInput = $box.find( '.display-title' ),
					$descInput = $box.find( '.description' ),
					$thumb = $box.find( '.video-thumb' );

				$this.addVideoButton({
					callbackAfterSelect: function( url, vet ) {

						$.nirvana.sendRequest({
							controller: 'VideoPageToolSpecial',
							method: 'getVideoData',
							type: 'GET',
							format: 'json',
							data: {
								url: url
							},
							callback: function( json ) {
								if( json.result === 'ok' ) {

									var video = json.video;

									// update input value and remove any error messages that might be there.
									$videoKeyInput
										.val( video.videoKey )
										.removeClass( 'error' )
										.next( '.error' )
										.remove();
									$videoTitle.removeClass( 'alternative' )
										.text( video.videoTitle );
									$displayTitleInput.val( video.displayTitle );
									$descInput.val( video.description );
									$thumb.html( video.videoThumb );
									// close VET modal
									vet.close();
								} else {
									window.GlobalNotification.show( json.msg, 'error' );
								}
							}
						});

						// Don't move on to second VET screen.  We're done.
						return false;
					}
				});
			});
		},
		initSwitcher: function() {
			this.$form.switcher({
				onChange: function( $elem, $switched ) {
					// Update the numbers beside the elements
					var $oCount = $elem.find( '.count' ),
						oCountVal = $oCount.html(),
						$nCount = $switched.find( '.count' ),
						nCountVal = $nCount.html();

					$oCount.html( nCountVal );
					$nCount.html( oCountVal );
				}
			});
		},
		initValidator: function() {

			this.validator = new Validator({
				form: this.$form,
				formFields: this.$formFields
			});

			// Set min length rule for description textarea
			this.validator.setRule( this.$formFields.filter( '.description' ), 'minlength', 200 )

			this.$formFields.each( this.validator.addRules );
			this.$form.on( 'submit', this.validator.onSubmit );

			// If the back end has thrown an error, run the front end validation on page load
			if( $( '#vpt-form-error' ).length ) {
				this.validator.checkFields();
			}
		},
		initReset: function() {
			var that = this;

			this.$form.find( '.reset' ).on( 'click', function(e) {
				e.preventDefault();

				$.confirm({
					title: $.msg( 'videopagetool-confirm-clear-title' ),
					content: $.msg( 'videopagetool-confirm-clear-message' ),
					onOk: function() {
						that.clearFeaturedVideoForm();
					},
					width: 700
				});

			});
		},
		/*
		 * This reset is very specific to this form since it covers reverting titles and thumbnails
		 * @todo: we may want to just create a default empty version of the form and hide it if it's not needed.
		 * That way we could just replace all the HTML to its default state without worrying about clearing every form
		 * field.
		 */
		clearFeaturedVideoForm: function() {
			// Clear all form input values.
			this.$form.find( 'input:text, input:hidden, textarea' ).val( '' );
			// Reset video title
			this.$form.find( '.video-name' ).text( $.msg( 'videopagetool-video-title-default-text' ) );
			// Rest the video thumb
			this.$form.find( '.video-thumb' ).html( '' );
			// Also clear all error messages for better UX
			this.validator.clearErrors();
		}
	};

	return VPTEdit;
});

require(['vpt.views.edit'], function(EditView) {

	'use strict';

	$(function() {
		new EditView();
	});
});
