'use strict';

var StoriesLinkTag = {
	sliderEnabled: true,

	init: function (markerId) {
		var that = this,
			timer = null,
			$unit = $('#storiesLinkTag-' + markerId),
			$currentImage = $unit.find('.storieslink-tag-slider-0');	// Always start on first image

		$currentImage.find('.nav').addClass('selected');
		$currentImage.find('.description').show();
		$currentImage.find('.description-background').show();

		//bind events
		$unit.find('.nav').click(function() {
			if ( $unit.find('.storieslink-tag-slider').queue().length === 0 ) {
				clearInterval(timer);
				StoriesLinkTag.scroll($(this));
			}
		});

		// kill slider while closing preview in edit mode
		$(window).bind('EditPagePreviewClosed', function() {
			clearInterval(timer);
			StoriesLinkTag.sliderEnabled = true;
		});

		$unit.show();

		// only animate slider with more than one item
		if ($unit.find('ul').children().length > 1) {
			timer = setInterval(function() {
				that.slideshow($unit);
			}, 7000);
		}
	},

	scroll: function($thumb) {
		var thumbIndex = $thumb.parent().index(),
			scrollBy = parseInt($thumb.parent().find('.storieslink-tag-slider').css('left')),
			$unit = $thumb.closest('.storieslink-tag'),
			$description = $unit.find('.storieslink-tag-slider-' + thumbIndex).find('.description');

		if ($unit.find('.storieslink-tag-slider').queue().length === 0) {
			$unit.find('.nav').removeClass('selected');
			$thumb.addClass('selected');

			$unit.find('.description').clearQueue().hide();

			$unit.find('.storieslink-tag-slider').animate({
				left: '-=' + scrollBy
			}, function() {
				$description.fadeIn();
			});
		}
	},

	slideshow: function($unit) {
		if (StoriesLinkTag.sliderEnabled) {
			var totalItems = $unit.find('.nav').length,
				current = $unit.find('.selected').parent().index(),
				next = 0;

			if ((current < totalItems - 1 ) && (totalItems <= 4)) {
				next = current + 1;
			}

			StoriesLinkTag.scroll($unit.find('.storieslink-tag-slider-' + next + ' .nav'));
		}
	}

};
