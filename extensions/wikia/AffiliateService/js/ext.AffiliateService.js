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


		// prepend the unit after the first paragraph below the infobox
		$paragraphs.each(function(index, element) {
			var $paragraph = $(element);
			var paragraphHeight = $paragraph.offset().top;

			if (paragraphHeight > startHeight) {
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
