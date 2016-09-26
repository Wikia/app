'use strict';

var CrosslinkTag = {
	sliderEnabled: true,

	init: function (markerId) {
		var that = this,
			timer = null,
			$crosslinkUnit = $('#crosslinkTag-' + markerId),
			$currentImage = $crosslinkUnit.find('.crosslink-tag-slider-0');	// Always start on first image

		$currentImage.find('.nav').addClass('selected');
		$currentImage.find('.description').show();
		$currentImage.find('.description-background').show();

		//bind events
		$crosslinkUnit.find('.nav').click(function() {
			if ( $crosslinkUnit.find('.crosslink-tag-slider').queue().length === 0 ) {
				clearInterval(timer);
				CrosslinkTag.scroll($(this));
			}
		});

		// kill slider while closing preview in edit mode
		$(window).bind('EditPagePreviewClosed', function() {
			clearInterval(timer);
			CrosslinkTag.sliderEnabled = true;
		});

		$crosslinkUnit.show();

		// only animate slider with more than one item
		if ($crosslinkUnit.find('ul').children().length > 1) {
			timer = setInterval(function() {
				that.slideshow($crosslinkUnit);
			}, 7000);
		}
	},

	scroll: function($thumb) {
		var thumbIndex = $thumb.parent().index(),
			scrollBy = parseInt($thumb.parent().find('.crosslink-tag-slider').css('left')),
			$crosslinkUnit = $thumb.closest('.crosslink-tag'),
			$description = $crosslinkUnit.find('.crosslink-tag-slider-' + thumbIndex).find('.description');

		if ($crosslinkUnit.find('.crosslink-tag-slider').queue().length === 0) {
			$crosslinkUnit.find('.nav').removeClass('selected');
			$thumb.addClass('selected');

			$crosslinkUnit.find('.description').clearQueue().hide();

			$crosslinkUnit.find('.crosslink-tag-slider').animate({
				left: '-=' + scrollBy
			}, function() {
				$description.fadeIn();
			});
		}
	},

	slideshow: function($crosslinkUnit) {
		if (CrosslinkTag.sliderEnabled) {
			var totalItems = $crosslinkUnit.find('.nav').length,
				current = $crosslinkUnit.find('.selected').parent().index(),
				next = 0;

			if ((current < totalItems - 1 ) && (totalItems <= 4)) {
				next = current + 1;
			}

			CrosslinkTag.scroll($crosslinkUnit.find('.crosslink-tag-slider-' + next + ' .nav'));
		}
	}

};
