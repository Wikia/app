/*global WikiaMobile: true */

var WikiaPhotoGallerySlider = {
	sliderId: null,
	loader: WikiaMobile.loader,

	init: function(sliderId) {
		this.sliderId = sliderId;

		var slider = $('#wikiaPhotoGallery-slider-body-' + sliderId ),
		initialImageId = 0, //for now always first
		initialSlider = $('#wikiaPhotoGallery-slider-' + sliderId + '-' + initialImageId),
		image = initialSlider.find('a img');

		image.one('load',function() {
			WikiaPhotoGallerySlider.loader.hide(slider[0]);
		});
		this.loader.show(slider[0],{center:true});

		//ensure that there are no more than 4 images in the slider
		//the 'mosaic' style slider for www hubs has 5 images
		slider.find('li').each(function(index, element) {
			if (index > 3) {
				$(element).remove();
			}
		});

		//select nav
		initialSlider.find('.nav').addClass('selected');

		//show description
		initialSlider.find('.description').addClass('visible');

		//load image
		image.show().attr('src', image.data('src'));

		//bind events
		slider.delegate('.nav', 'click', function() {
			WikiaPhotoGallerySlider.scroll($(this));
		});

		slider.show();
	},

	scroll: function(nav) {
		//setup variables
		var parentNav = nav.parent(),
		image = parentNav.find('a img'),
		imageData = image.data('src'),
		slider = parentNav.parents('.wikiaPhotoGallery-slider-body');

		//set 'selected' class
		slider.find('.nav').removeClass('selected');
		nav.addClass('selected');

		//show relevant description
		slider.find('.description').removeClass('visible');
		parentNav.find('.description').addClass('visible');

		//show relevant img
		slider.find('a img').hide();
		if( imageData && imageData != image.attr('src')) {
			image.one('load',function() {
				WikiaPhotoGallerySlider.loader.hide(slider[0]);
			});
			image.attr('src', imageData);
			this.loader.show(slider[0],{center:true});
		}
		image.show();
	}
}
