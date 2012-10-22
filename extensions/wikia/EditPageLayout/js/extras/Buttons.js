(function(window, $) {
	var buttons = window.wgEditorExtraButtons = window.wgEditorExtraButtons || {};

	var checkGallery = function() {
		return typeof window.WikiaPhotoGallery != 'undefined';
	};

	var getTextarea = function() {
		return WikiaEditor.getInstance().getEditbox()[0];
	};

	buttons['InsertImage'] = {
		type: 'button',
		labelId: 'wikia-editor-media-image',
		titleId: 'wikia-editor-media-image-tooltip',
		className: 'RTEImageButton',
		forceLogin: true,
		clicksource: function() {
			WikiaEditor.load( 'WikiaMiniUpload' ).done(function() {
				WMU_show({});
			});
		},
		ckcommand: 'addimage'
	};

	buttons['InsertGallery'] = {
		type: 'button',
		labelId: 'wikia-editor-media-gallery',
		titleId: 'wikia-editor-media-gallery-tooltip',
		className: 'RTEGalleryButton',
		forceLogin: true,
		clicksource: function() {
			WikiaPhotoGallery.showEditor({
				from: 'source',
				type: WikiaPhotoGallery.TYPE_GALLERY
			});
		},
		ckcommand: 'addgallery',
		precondition: checkGallery
	};

	buttons['InsertSlideshow'] = {
		type: 'button',
		labelId: 'wikia-editor-media-slideshow',
		titleId: 'wikia-editor-media-slideshow-tooltip',
		className: 'RTESlideshowButton',
		forceLogin: true,
		clicksource: function() {
			WikiaPhotoGallery.showEditor({
				from: 'source',
				type: WikiaPhotoGallery.TYPE_SLIDESHOW
			});
		},
		ckcommand: 'addslideshow',
		precondition: checkGallery
	};

	buttons['InsertSlider'] = {
		type: 'button',
		labelId: 'wikia-editor-media-slider',
		titleId: 'wikia-editor-media-slider-tooltip',
		className: 'RTESliderButton',
		forceLogin: true,
		clicksource: function() {
			WikiaPhotoGallery.showEditor({
				from: 'source',
				type: WikiaPhotoGallery.TYPE_SLIDER
			});
		},
		ckcommand: 'addslider',
		precondition: checkGallery
	};

	buttons['InsertVideo'] = {
		type: 'button',
		labelId: 'wikia-editor-media-video',
		titleId: 'wikia-editor-media-video-tooltip',
		className: 'RTEVideoButton',
		forceLogin: true,
		clicksource: function() {
			WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
				VET_show({
					target: {
						id: 'mw-editbutton-vet'
					}
				});
			});
		},
		ckcommand: 'addvideo'
	};

	buttons['SourceBold'] = {
		type: 'button',
		labelId: 'wikia-editor-source-bold',
		titleId: 'wikia-editor-source-bold-tooltip',
		className: 'cke_button_bold',
		clicksource: function() {
			insertTags( "'''", "'''", "Bold text", getTextarea());
		}
	};

	buttons['SourceItalic'] = {
		type: 'button',
		labelId: 'wikia-editor-source-italic',
		titleId: 'wikia-editor-source-italic-tooltip',
		className: 'cke_button_italic',
		clicksource: function() {
			insertTags( "''", "''", "Italic text", getTextarea());
		}
	};

	buttons['SourceLink'] = {
		type: 'button',
		labelId: 'wikia-editor-source-link',
		titleId: 'wikia-editor-source-link-tooltip',
		className: 'cke_button_link',
		clicksource: function() {
			insertTags( "[[", "]]", "Link title", getTextarea());
		}
	};

})(this, jQuery);