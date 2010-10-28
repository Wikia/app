$(window).load(function() {
    LatestPhotos.init();
});

var LatestPhotos = {
	browsing: false,
	transition_speed: 500,
	enable_next: true,
	enable_previous: false,
	carousel: false,

	init: function() {
		LatestPhotos.carousel = $('.LatestPhotosModule').find('.carousel');
		LatestPhotos.attachListeners();
		//LatestPhotos.lazyLoadImages(3);
	},

	lazyLoadImages: function(limit) {
		//var firstInit = true;
		var images = this.carousel.find('img').filter('[data-src]');
		$().log('lazy loading rest of images', 'LatestPhotos');

		var count = 0;
		images.each(function() {
			count ++;
			if (count > limit) { // exit the loop for init image loading.
				return false;
			}
			//if ( ( firstInit == false  && count > LatestPhotos.initLoadedImages) || firstInit == true) {
				var image = $(this);
				image.
					attr('src', image.attr('data-src')).
					removeAttr('data-src');
			//}
		});

	},

	attachListeners: function() {
		LatestPhotos.attachBlindImages();
		$('.LatestPhotosModule .next').click(LatestPhotos.nextImage);
		$('.LatestPhotosModule .previous').click(LatestPhotos.previousImage);

		$(".LatestPhotosModule").one('mouseover', function() {
			LatestPhotos.lazyLoadImages('rest');
		});

		LatestPhotos.enableBrowsing();
		LatestPhotos.addLightboxTracking();
	},

	attachBlindImages: function() {
		if ($('.carousel li').length == 5) {
			$('.carousel').append("<li class='blind'></li>");
		}
		else if ($('.carousel li').length == 4) {
			$('.carousel').append("<li class='blind'></li>");
			$('.carousel').append("<li class='blind'></li>");
		}

		$('.carousel li').first().addClass("first-image");
		$('.carousel li').last().addClass("last-image");

	},

	previousImage: function() {
		var width = LatestPhotos.setCarouselWidth();

		LatestPhotos.enableBrowsing();

		if (LatestPhotos.browsing == false && LatestPhotos.enable_previous == true) {
			LatestPhotos.browsing = true;
			var images = $('.carousel li').length;
			for (i=0; i < 3; i++) {
				$('.carousel').prepend( $('.carousel li').eq(images -1) ) ;
			}
			$(".carousel-container div").css('left', - width + 'px');

			$(".carousel-container div").animate({
				left:  '0px'
			}, LatestPhotos.transition_speed, function() {
				LatestPhotos.browsing = false;
			});
		}
		return false;
	},

	nextImage: function() {
		var width = LatestPhotos.setCarouselWidth();

		LatestPhotos.enableBrowsing();

		if (LatestPhotos.browsing == false && LatestPhotos.enable_next == true) {
			LatestPhotos.browsing = true;
			$(".carousel-container div").animate({
				left: '-' + width
			}, LatestPhotos.transition_speed, function() {
				LatestPhotos.removeFirstPhotos();
				LatestPhotos.browsing = false;
			});
		}
		return false;
	},

	enableBrowsing: function() {
		var current = $('.carousel li').slice(0, 3).each(function (i) {
			if ($(this).is('.last-image')) {
				LatestPhotos.enable_next = false;
				return false;
			}
			else {
				LatestPhotos.enable_next = true;
			}

			if ($(this).is('.first-image')) {
				LatestPhotos.enable_previous = false;
				return false;
			}
			else {
				LatestPhotos.enable_previous = true;
			}
		});
	},

	// add extra tracking for lightbox shown for image from latest photos module (RT #74852)
	addLightboxTracking: function() {
		this.carousel.bind('lightbox', function(ev, lightbox) {
			$().log('lightbox shown', 'LatestPhotos');

			var fakeUrl = 'module/latestphotos/';
			var lightboxCaptionLinks = $('#lightbox-caption-content').find('a');

			// user name
			lightboxCaptionLinks.eq(0).trackClick(fakeUrl + 'lightboxusername');

			// page name
			lightboxCaptionLinks.filter('.wikia-gallery-item-posted').trackClick(fakeUrl + 'lightboxlink');

			// "more"
			lightboxCaptionLinks.filter('.wikia-gallery-item-more').trackClick(fakeUrl + 'lightboxmore');
		});
	},

	removeFirstPhotos: function() {
		var old = $('.carousel li').slice(0,3);
		$('.carousel-container div').css('left', '0px');
		$('.carousel li').slice(0,3).remove();
		$('.carousel').append(old);

	},

	setCarouselWidth: function() {
		var width = $(".carousel li").outerWidth() * 3 + 6;
		$('.carousel').css('width', width * $(".carousel li").length + 'px'); // all li's in one line
		return width;
	}
};