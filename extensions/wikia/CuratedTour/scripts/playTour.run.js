/**
 * This file is executed on the Special:CuratedTour page.
 */
require(
	[
		'jquery',
		'ext.wikia.curatedTour.tourGuide'
	],
	function ($, TourGuide) {
		'use strict';

		$(function() {
			var playButton = $('.ct-play-button');
			if (playButton.length > 0) {
				playButton.on('click', TourGuide.startTour);
			} else {
				TourGuide.init();
			}
		});
	}
);
