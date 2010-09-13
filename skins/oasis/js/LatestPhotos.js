$(function() {
	LatestPhotos.init();
});

var LatestPhotos = {
	browsing: false,
	transition_speed: 500,
	init: function() {
		this.attachListeners();
	},

	attachListeners: function() {
		LatestPhotos.attachBlindImages();
		$('.LatestPhotosModule .next').click(LatestPhotos.nextImage);
		$('.LatestPhotosModule .previous').click(LatestPhotos.previousImage);
	},

	attachBlindImages: function() {
		if ($('.carousel li').length == 5) {
			$('.carousel').append("<li class='blind'></li>");
		}
		else if ($('.carousel li').length == 4) {
			$('.carousel').append("<li class='blind'></li>");
			$('.carousel').append("<li class='blind'></li>");
		}
	},

	previousImage: function() {
		var width = LatestPhotos.setCarouselWidth();

		if (LatestPhotos.browsing == false) {
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

		if (LatestPhotos.browsing == false) {
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