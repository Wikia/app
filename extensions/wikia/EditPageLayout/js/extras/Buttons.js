(function(window, $) {
	var buttons = window.wgEditorExtraButtons,
		extensionsPath = window.wgExtensionsPath,
		mediawikiButtons = window.mwCustomEditButtons;

	if ( !buttons ) {
		buttons = window.wgEditorExtraButtons = {};
	}

	function checkGallery() {
		return typeof window.WikiaPhotoGallery != 'undefined';
	}

	function getTextarea() {
		return WikiaEditor.getInstance().getEditbox()[0];
	}

	/**
	 * Editor right rail buttons
	 */

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

	if( window.wgEnableVideoToolExt ) {
		buttons['InsertVideo'] = {
			type: 'button',
			labelId: 'wikia-editor-media-video',
			titleId: 'wikia-editor-media-video-tooltip',
			className: 'RTEVideoButton',
			forceLogin: true,
			clicksource: function() {
				WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
					window.VET_WikiaEditor({
						target: {
							id: 'mw-editbutton-vet'
						}
					});
				});
			},
			ckcommand: 'addvideo'
		};
	}

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

	/**
	 * Mediawiki toolbar buttons (Oasis skin only)
	 */

	if ( skin == 'oasis' && mediawikiButtons ) {
		if ( window.wgEnableWikiaMiniUploadExt ) {
			mediawikiButtons.push({
				imageFile: extensionsPath + '/wikia/WikiaMiniUpload/images/button_wmu.png',
				speedTip: wmu_imagebutton,
				imageId: 'mw-editbutton-wmu',
				onclick: function( event ) {
					WikiaEditor.load( 'WikiaMiniUpload' ).done(function() {
						WMU_show( event );
					});
				}
			});
		}

		if ( window.wgEnableWikiaPhotoGalleryExt ) {
			mediawikiButtons.push({
				imageFile: extensionsPath + '/wikia/WikiaPhotoGallery/images/gallery_add.png',
				speedTip: window.WikiaPhotoGalleryAddGallery,
				imageId: 'mw-editbutton-wpg',
				onclick: function() {
					WikiaPhotoGallery.showEditor({
						from: 'source'
					});
				}
			});
		}

		// Check to see if wiki allows embedding videos, as well as checking user permissions
		if ( window.wgEnableVideoToolExt && window.showAddVideoBtn) {
			mediawikiButtons.push({
				imageFile: extensionsPath + '/wikia/VideoEmbedTool/images/button_vet.png',
				speedTip: $.msg('vet-imagebutton'),
				imageId: 'mw-editbutton-vet',
				onclick: function( event ) {
					WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
						window.VET_WikiaEditor( event );
					});
				}
			});
		}
	}

})(this, jQuery);
