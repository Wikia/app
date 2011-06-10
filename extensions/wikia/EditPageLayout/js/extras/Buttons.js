(function(window,$){
	
	var buttons = window.wgEditorExtraButtons = window.wgEditorExtraButtons || {};
	
	var checkGallery = function() {
		return typeof window.WikiaPhotoGallery != 'undefined';
	};
	var checkVET = function() {
		return typeof window.VET_show == 'function';
	};
	
	buttons['InsertImage'] = {
		type: 'button',
		labelId: 'wikia-editor-media-image',
		titleId: 'wikia-editor-media-image-tooltip',
		className: 'RTEImageButton',
		clicksource: function() { WMU_show({}); },
		ckcommand: 'addimage'
	};
	buttons['InsertGallery'] = {
		type: 'button',
		labelId: 'wikia-editor-media-gallery',
		titleId: 'wikia-editor-media-gallery-tooltip',
		className: 'RTEGalleryButton',
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
		clicksource: function() { VET_show({}); },
		ckcommand: 'addvideo',
		precondition: checkVET
	};
	
})(this,jQuery);