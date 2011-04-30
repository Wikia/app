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
		label: 'Image',
		className: 'RTEImageButton',
		clicksource: function() { WMU_show({}); },
		ckcommand: 'addimage'
	};
	buttons['InsertGallery'] = {
		type: 'button',
		label: 'Gallery',
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
		label: 'Slideshow',
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
		label: 'Slider',
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
		label: 'Video',
		className: 'RTEVideoButton',
		clicksource: function() { VET_show({}); },
		ckcommand: 'addvideo',
		precondition: checkVET
	};
	
})(this,jQuery);