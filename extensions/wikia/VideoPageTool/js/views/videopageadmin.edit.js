define( 'views.videopageadmin.edit', [
	'jquery',
	'models.videopageadmin.validator',
	'views.videopageadmin.thumbnailupload'
], function( $, Validator, ThumbnailUploader ) {

	'use strict';

	var VPTEdit = function() {
		this.$form = $( '.vpt-form' );
		// all elements to be validated - jQuery validate doesn't support arrays of form names inputs like "names[]" :(
		this.$formFields = this.$form.find( '.description, .display-title, .video-key, .alt-thumb' );
		this.init();
	};

	VPTEdit.prototype = {
		init: function() {
			this.initValidator();
			this.initReset();
			this.initSwitcher();
			this.initAddVideo();
			this.initMediaUploader();
		},

		initMediaUploader: function() {
			$( '.form-box' ).on( 'click', '.media-uploader-btn', function(evt) {
					evt.preventDefault();
					return new ThumbnailUploader({
							el: $(this).closest('.form-box')
					});
			});
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
						var $altThumbKey,
								req;

						$altThumbKey = $box.find('.alt-thumb').val();
						req = {};

						if ( $altThumbKey.length ) {
							req.altThumbKey = $altThumbKey;
						}

						req.url = url;

						$.nirvana.sendRequest({
							controller: 'VideoPageAdminSpecial',
							method: 'getVideoData',
							type: 'GET',
							format: 'json',
							data: req,
							callback: function( json ) {
								if( json.result === 'ok' ) {

									var video = json.video;
									$thumb.html();

									// update input value and remove any error messages that might be there.
									$videoKeyInput
										.val( video.videoKey )
										.removeClass( 'error' )
										.next( '.error' )
										.remove();
									$videoTitle
										.removeClass( 'alternative' )
										.text( video.videoTitle );
									$displayTitleInput
										.val( video.displayTitle )
										.trigger( 'keyup' ); // for validation
									$descInput.val( video.description )
										.trigger( 'keyup' ); // for validation

									// Update thumbnail html
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
			var that = this;

			this.validator = new Validator({
				form: this.$form,
				formFields: this.$formFields
			});

			// Set max length rule for description textarea
			this.validator.setRule( this.$formFields.filter( '.description' ), 'maxlength', 200 );
			this.validator.setRule( this.$formFields.filter( '.alt-thumb' ), 'missingImage' );

			this.$formFields.each( this.validator.addRules );

			this.$form.on( 'submit', function( evt ) {
					evt.preventDefault();
					var success,
							$firstError;

					// check for errors
					success = that.validator.onSubmit();

					// jump back up to form box if errors are present
					if ( !success ) {
						$firstError = $( '.error' ).eq( 0 );
						$firstError
							.closest( '.form-box' )
							.get( 0 )
							.scrollIntoView( true );
					}
			});

			// If the back end has thrown an error, run the front end validation on page load
			if( $( '#vpt-form-error' ).length ) {
				this.validator.formIsValid();
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
		 * @TODO: we may want to just create a default empty version of the form and hide it if it's not needed.
		 * That way we could just replace all the HTML to its default state without worrying about clearing every form
		 * field.
		 */
		clearFeaturedVideoForm: function() {
			// Clear all form input values.
			this.$form.find( 'input:text, input:hidden, textarea' )
				.val( '' );

			// Reset video title
			this.$form.find( '.video-title' )
				.text( $.msg( 'videopagetool-video-title-default-text' ) )
				.addClass( 'alternative' );

			// Rest the video thumb
			this.$form.find( '.video-thumb' )
				.html( '' );

			// Hide all thumbnail preview links
			this.$form.find( '.preview-large-link' )
				.hide();

			// reset custom thumb name
			this.$form.find( '.alt-thumb-name' )
				.text( $.msg('videopagetool-image-title-default-text') );

			// Also clear all error messages for better UX
			this.validator.clearErrors();
		}
	};

	return VPTEdit;
});

require(['views.videopageadmin.edit'], function(EditView) {

	'use strict';

	$(function() {
		new EditView();
	});
});
