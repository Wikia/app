define('ext.wikia.curatedTour.tourGuide',
	[
		'ext.wikia.curatedTour.tourNavigator',
		'wikia.cookies'
	],
	function (TourNavigator, cookies) {
		'use strict';

		var onTourCookie = 'curatedTourIsOn',
			ttl = 60 * 60 * 3;

		function startTour(event) {
			event.preventDefault();

			cookies.set(onTourCookie, '1', {expires: ttl});

			TourNavigator.goToStep(1);
		}

		return {
			startTour: startTour
		}
	}
);
