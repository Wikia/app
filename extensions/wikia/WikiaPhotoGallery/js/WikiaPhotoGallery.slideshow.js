var WikiaPhotoGallerySlideshow = {
	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery:Slideshow');
	},

	init: function(params) {
		var slideshow = $('#' + params.id);
		var cb = function(index) {
			var item = slideshow.find('li').eq(index);
			if (item.attr('title')) {
				item.css('backgroundImage', 'url(' + item.attr('title') + ')');
				item.removeAttr('title');
			}
		};

		var item = slideshow.find('li').first();
		if (item.attr('title') != '') {
			item.css('backgroundImage', 'url(' + item.attr('title') + ')');
		}
		item.removeAttr('title');

		slideshow.slideshow({
			buttonsClass: 'wikia-button',
			nextClass: 'wikia-slideshow-next',
			prevClass: 'wikia-slideshow-prev',
			slideWidth: params.width,
			slidesClass: 'wikia-slideshow-images',
			slideCallback: cb
		});

		this.log('#' + params.id + ' initialized');
	}
}