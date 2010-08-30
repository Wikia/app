$(function() {
	LatestPhotos.init();
});

var LatestPhotos = {
	browsing: false,
	transition_speed: 200,
	init: function() {
		this.attachListeners();
	},
	attachListeners: function() {
		$(".LatestPhotosModule").find(".next").click(LatestPhotos.nextImage);
		$(".LatestPhotosModule").find(".previous").click(LatestPhotos.previousImage);
	},
	nextImage: function() {
		var visibles = $(".LatestPhotosModule li:visible");
		var invisbles = $(".LatestPhotosModule li:hidden");
		var next = $(visibles).last().next();		
		if (LatestPhotos.browsing == false) {
			if (!$(next).exists()) {
				invisbles.remove();
				$(visibles).parent().append(invisbles);
				next = $(visibles).last().next();
			}
			LatestPhotos.browsing = true;
			$(visibles).first().hide(LatestPhotos.transition_speed);
			$(next).show(LatestPhotos.transition_speed, function() {
				LatestPhotos.browsing = false;
			});
		}
		return false;
	},
	previousImage: function() {
		var visibles = $(".LatestPhotosModule li:visible");
		var invisibles = $(".LatestPhotosModule li:hidden");
		var prev = $(visibles).first().prev();
		if (LatestPhotos.browsing == false) {
			$(".LatestPhotosModule li:visible").last().hide(LatestPhotos.transition_speed);
			if (!$(prev).exists()) {
				var last = $(invisibles).last();
				$(invisibles).last().remove();
				$(visibles).parent().prepend(last);
				$(".LatestPhotosModule li").first().hide();
			}
			LatestPhotos.browsing = true;
			$(visibles).prev().first().show(LatestPhotos.transition_speed, function() {
				LatestPhotos.browsing = false;
			});
		}
		return false;
	}
};