// find the first slot where we can insert
// todo: we could use a better algorithm here
function insertSpot(arr, val) {
	for (var i = 0; i < arr.length - 1; i++) {
		var arrVal = arr[i];
		var nextVal = arr[i + 1];

		if (i === 0 && arrVal > val) {
			return -1;
		}

		if (arrVal <= val && nextVal > val) {
			return i;
		}
	}

	return arr.length;
}

require(['jquery', 'mw'], function ($, mw) {
	'use strict';
	$(function () {
		var $infoBox = $('.portable-infobox').first();

		if (!$infoBox) {
			return;
		}

		var infoboxOffset = $infoBox.offset();
		var infoboxHeight = $infoBox.height();
		var startHeight = infoboxOffset.top + infoboxHeight;

		// only select paragraphs one level from the root main element
		var $paragraphs = $('#mw-content-text > p');

		// don't select placement near images
		var $images = $('#mw-content-text > figure');
		var notAllowedYStart = []; // array of y coordinate start positions
		var notAllowedYStop = [] // array of y coordinate final positions

		$images.each(function(index, element) {
			var $image = $(element);
			var imageStart = $image.offset().top;
			notAllowedYStart.push(imageStart);
			notAllowedYStop.push(imageStart + $image.height());
		});

		function isValidSlot(yStart) {
			var index = insertSpot(notAllowedYStart, yStart);

			// no images yet
			if (index === -1) {
				return true;
			}

			var notAllowedYStartValue = notAllowedYStart[index];
			var notAllowedYStopValue = notAllowedYStop[index];

			if (notAllowedYStopValue < yStart) {
				return true;
			}

			return false;
		}

		// prepend the unit after the first paragraph below the infobox
		$paragraphs.each(function(index, element) {
			var $paragraph = $(element);
			var paragraphY = $paragraph.offset().top;

			if (paragraphY > startHeight && isValidSlot(paragraphY)) {
				$paragraph.prepend('<div style="background: red; width: 100%; height: 100px"> </div>')
				return false;
			}

		});


		// iterate through all of the paragraphs comparing the widths of each one. When there is a width that is much larger
		// than the previous high use that. Only look at the first N paragraphs.
		// var widths = [];
		// var defaultSlot = null;
		// $paragraphs.each(function(index, element) {
		// 	var $paragraph = $(element);
		// 	var paragraphWidth = $paragraph.width();
		// 	widths.push(paragraphWidth);

		// 	var maxWidth = Math.max.apply(null, widths);

		// 	if (index > 2) {
		// 		console.log(paragraphWidth, maxWidth);
		// 		if (paragraphWidth > maxWidth) {
		// 			$paragraph.append('<div style="background: blue; width: 100%; height: 100px"> </div>')
		// 			return false;
		// 		}
		// 	}
		// });

	});
});
