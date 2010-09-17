$(function() {
	LatestPhotos.init();
});

var LatestPhotos = {
	browsing: false,
	transition_speed: 500,
	enable_next: true,
	enable_previous: false,
	carousel: false,

	init: function() {
		this.carousel = $('.LatestPhotosModule').find('.carousel');
		this.attachListeners();
		this.lazyLoadImages();
	},

	lazyLoadImages: function() {
		var images = this.carousel.find('img').filter('[data-src]');
		$().log('lazy loading images', 'LatestPhotos');

		images.each(function() {
			var image = $(this);
			image.
				attr('src', image.attr('data-src')).
				removeAttr('data-src');
		});
	},

	attachListeners: function() {
		LatestPhotos.attachBlindImages();
		$('.LatestPhotosModule .next').click(LatestPhotos.nextImage);
		$('.LatestPhotosModule .previous').click(LatestPhotos.previousImage);

		LatestPhotos.enableBrowsing();
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