define('ext.wikia.curatedTour.tourGuide',
	[
		'ext.wikia.curatedTour.navigatorBox',
		'ext.wikia.curatedTour.tourNavigator',
		'jquery',
		'wikia.cookies',
		'wikia.window'
	],
	function (NavigatorBox, TourNavigator, $, cookies, window) {
		'use strict';

		var onTourCookie = 'curatedTourIsOn',
			ttl = 60 * 60 * 3;

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
		}
	}
);
