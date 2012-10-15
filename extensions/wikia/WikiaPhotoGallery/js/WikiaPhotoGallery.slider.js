var WikiaPhotoGallerySlider = {
	//timer for automatic wikiaPhotoGallery slideshow
	timer: null,
	sliderEnable: true,

	//ID of image that will be shown on load, integer, 0-3
	initialImageId: 0, //Math.floor(Math.random() * 4),

	sliderId: null,

	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery:Slider');
	},

	init: function(sliderId) {
		this.sliderId = sliderId;
		$().log('Slider');
		$().log(this.sliderId);
		//move spotlights
		$('.wikiaPhotoGallery-slider-body').each(function() {
			var node = $(this);
			node.css('left', parseInt(node.css('left')) - (620 * WikiaPhotoGallerySlider.initialImageId), 10);
		});

		var currentImage = $('#wikiaPhotoGallery-slider-' + sliderId + '-' + WikiaPhotoGallerySlider.initialImageId);

		//select nav
		currentImage.find('.nav').addClass('selected');

		//show description
		currentImage.find('.description').show();
		currentImage.find('.description-background').show();

		//bind events
		$('#wikiaPhotoGallery-slider-body-' + sliderId + ' .nav').click(function() {
			if ( $('#wikiaPhotoGallery-slider-body-' + sliderId + ' .wikiaPhotoGallery-slider').queue().length == 0 ){
				clearInterval(WikiaPhotoGallerySlider.timer);
				WikiaPhotoGallerySlider.scroll($(this));
			}
		});
		$('.wikiaPhotoGallery-slider-body ul li a').click(function() {
			WikiaPhotoGallerySlider.sliderEnable = false;
		});

		$('#wikiaPhotoGallery-slider-body-' + sliderId).show();

		//only slideshows with more than one item should animate
		if ($('#wikiaPhotoGallery-slider-body-' + sliderId).find('ul').children().length > 1) {
			this.timer = setInterval(this.slideshow, 7000);
		}
	},

	scroll: function(nav) {
		//setup variables
		var thumb_index = nav.parent().prevAll().length,
			scroll_by = parseInt(nav.parent().find('.wikiaPhotoGallery-slider').css('left')),
			slider_body = nav.closest('.wikiaPhotoGallery-slider-body'),
			parent_id = slider_body.attr('id');

		if ($('#' + parent_id + ' .wikiaPhotoGallery-slider').queue().length == 0) {

			//set 'selected' class
			$('#' + parent_id + ' .nav').removeClass('selected');
			nav.addClass('selected');

			//hide description
			$('#' + parent_id + ' .description').clearQueue().hide();

			//scroll
			$('#' + parent_id + ' .wikiaPhotoGallery-slider').animate({
				left: '-=' + scroll_by
			}, function() {
				slider_body.find( '.wikiaPhotoGallery-slider-' + thumb_index ).find( '.description' ).fadeIn();
			});
		}
	},

	slideshow: function() {
		if (WikiaPhotoGallerySlider.sliderEnable) {
			var current = $('#wikiaPhotoGallery-slider-body-' + WikiaPhotoGallerySlider.sliderId + ' .selected').parent().prevAll().length;
			var next = ( ( current == $('#wikiaPhotoGallery-slider-body-' + WikiaPhotoGallerySlider.sliderId + ' .nav').length - 1 ) || ( current > 3 ) ) ? 0 : current + 1;
			WikiaPhotoGallerySlider.scroll($('#wikiaPhotoGallery-slider-' + WikiaPhotoGallerySlider.sliderId + '-' + next).find('.nav'), WikiaPhotoGallerySlider.sliderId);
		}
	}
}
