var WikiaPhotoGallerySlider = {
	//timer for automatic wikiaPhotoGallery slideshow
	timer: null,
	//sliderEnable: true,

	//ID of image that will be shown on load, integer, 0-3
	initialImageId: Math.floor(Math.random() * 4),

	sliderId: null,

	log: function(msg) {
		console.log(msg, 'WikiaPhotoGallery:Slider');
	},

	init: function(sliderId) {
		this.sliderId = sliderId;
		var initialSlider = $('#wikiaPhotoGallery-slider-' + sliderId + '-' + WikiaPhotoGallerySlider.initialImageId),
			slider = $('#wikiaPhotoGallery-slider-body-' + sliderId );

		//select nav
		initialSlider.find('.nav').addClass('selected');

		//show description
		initialSlider.find('.description').addClass('visible');

		//bind events
		slider.delegate('.nav', 'click', function() {
				WikiaPhotoGallerySlider.scroll($(this))
		});

		$('.WikiaPhotoGalleryPreview').show();
	},

	scroll: function(nav) {
		//setup variables
		var parentNav = nav.parent(),
			slider = parentNav.parents('.wikiaPhotoGallery-slider-body');
		
		//set 'selected' class
		slider.find('.nav').removeClass('selected');
		nav.addClass('selected');

		//show relevant description
		slider.find('.description').removeClass('visible');
		parentNav.find('.description').addClass('visible');
		
		//show relevant img
		slider.find('a img').hide();
		parentNav.find('img').show();
	}
}