define('ext.wikia.curatedTour.tourGuide',
	[
		'ext.wikia.curatedTour.navigatorBox',
		'ext.wikia.curatedTour.tourNavigator',
		'jquery',
		'wikia.cookies'
	],
	function (NavigatorBox, TourNavigator, $, cookies) {
		'use strict';

		var onTourCookie = 'curatedTourIsOn',
			ttl = 1000 * 60 * 60 * 3; // 3 hours

		function init() {
			showNavigatorBox();

			TourNavigator.displayCurrentStep();
		}

		function startTour(event) {
			event.preventDefault();

			cookies.set(onTourCookie, '1', {expires: ttl});

			TourNavigator.goToStep(1);
		}

		function showNavigatorBox() {
			NavigatorBox.init();
		}

		return {
			init: init,
			startTour: startTour,
			showNavigatorBox: showNavigatorBox
		};
	}
);
