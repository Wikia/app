define( 'vpt.views.edit', [
	'jquery'
], function( $ ) {

	function VPTEdit() {
		this.$form = $( '.vpt-form' );
		this.validator = this.$form.validate({debug:false});
		// all elements to be validated - jQuery validate doesn't support arrays of form names inputs like "names[]" :(
		this.$formFields = this.$form.find( '.video_description, .video_display_title, .video_url' );
		this.init();
	}

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
					$urlInput = $this.siblings( '.video_url' ),
					$titleDisplay = $this.siblings( '.video-name' ),
					$titleInput = $box.find( '.video_display_title' ),
					$descInput = $box.find( '.video_description' ),
					$thumb = $box.find( '.video-thumb' );

				$this.addVideoButton({
					callbackAfterSelect: function( url, vet ) {
						// TODO: ajax request - send url, get back thumbnail html, title, description.  Hard coded for now

						var title = 'test title',
							description = 'test description',
							thumbHtml = '<a href="/wiki/File:007_James_Bond_Everything_or_Nothing_(VG)_(2004)_-_PS2-Gamecube-X-Box" data-external="0" data-ref="File:007_James_Bond_Everything_or_Nothing_(VG)_(2004)_-_PS2-Gamecube-X-Box" class="video image lightbox" style="overlay:hidden;height:84px;margin-bottom:6px;padding-top:3px;"><div class="timer">01:40</div><div class="Wikia-video-play-button" style="line-height:84px;width:150px;"><img class="sprite play small" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"></div><img alt="" src="http://images.liz.wikia-dev.com/__cb20120524192151/video151/images/thumb/5/52/007_James_Bond_Everything_or_Nothing_%28VG%29_%282004%29_-_PS2-Gamecube-X-Box/150px-007_James_Bond_Everything_or_Nothing_%28VG%29_%282004%29_-_PS2-Gamecube-X-Box.jpg" width="150" height="84" data-video-name="007 James Bond Everything or Nothing (VG) (2004) - PS2-Gamecube-X-Box" data-video-key="007_James_Bond_Everything_or_Nothing_%28VG%29_%282004%29_-_PS2-Gamecube-X-Box" data-src="http://images.liz.wikia-dev.com/__cb20120524192151/video151/images/thumb/5/52/007_James_Bond_Everything_or_Nothing_%28VG%29_%282004%29_-_PS2-Gamecube-X-Box/150px-007_James_Bond_Everything_or_Nothing_%28VG%29_%282004%29_-_PS2-Gamecube-X-Box.jpg" class="Wikia-video-thumb"></a>';

						// update input value and remove any error messages that might be there.
						$urlInput.val( url ).removeClass('error' ).next( '.error' ).remove();
						$titleDisplay.removeClass( 'alternative' ).text( title );
						$titleInput.val( title );
						$descInput.val( description );
						$thumb.html( thumbHtml );

						// close VET modal and return false to prevent the second window from opening
						vet.close();
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
						// Also clear all error messages for better UX
						that.$formFields.removeClass('error' ).next( '.error' ).remove();
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
