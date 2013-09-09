define( 'vpt.views.edit', [
	'jquery'
], function( $ ) {

	'use strict';

	var VPTEdit = function() {
		this.$form = $( '.vpt-form' );
		this.$submit = $( '#feature-videos-submit' );
		this.validator = this.$form.validate({
			//debug:false,
		});
		// all elements to be validated - jQuery validate doesn't support arrays of form names inputs like "names[]" :(
		this.$formFields = this.$form.find( '.video_description, .video_display_title, .video_url' );
		this.descriptionMinLength = 200;
		this.init();
	};

	VPTEdit.prototype = {
		init: function() {
			this.initValidate();
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
		initValidate: function() {
			var that = this;

			// add a rule to each element because validator can't handle array inputs by default (i.e. video_description[])
			this.$formFields.each( function() {
				var $this = $( this ),
					minLength = $this.is( '.video_description' ) ? that.descriptionMinLength : 0;

				$this.rules( 'add', {
					required: true,
					minlength: minLength,
					messages: {
						required: $.msg( 'htmlform-required' ),
						// Dynamically calculate the character length in the error message as you type.
						// Note: onkeyup needs to be set to false for this to work properly
						minlength: function( len, elem ) {
							var charsToGo = that.descriptionMinLength - $( elem ).val().length;
							return [ $.msg( 'videopagetool-description-minlength-error', len, charsToGo ) ];
						}
					},
					onkeyup: false
				});
			});

			this.$form.on( 'submit', function( e ) {
				e.preventDefault();

				// This is a bit of a hack to deal with jQuery validate's inability to handle input arrays
				var allValid = true;

				that.$formFields.each( function() {
					if ( !( that.validator.element( $( this ) ) ) ) {
						allValid = false;
					}
				});

				if( allValid ) {
					// call submit on the DOM element to prevent retriggering the jQuery event
					that.$form[0].submit();
				}
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
			this.$formFields.removeClass( 'error' ).next( '.error' ).remove();
		}
	};

	return VPTEdit;
});

require(['vpt.views.edit'], function(EditView) {
	$(function() {
		new EditView();
	});
});
