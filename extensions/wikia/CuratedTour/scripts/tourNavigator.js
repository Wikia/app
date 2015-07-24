define('ext.wikia.curatedTour.tourNavigator',
	[
		'ext.wikia.curatedTour.tourManager',
		'mw',
		'wikia.window'
	],
	function (TourManager, mw, window) {
		"use strict";

		function goToStep(step) {
			var index = getIndexFromStep(step);

			TourManager.getPlan(function (tourPlan) {
				var stepData = tourPlan[index];

				window.location.href = mw.config.get('wgServer') + '/' + stepData.PageName + '?curatedTour=' + step;
			});
		}

		function getIndexFromStep(step) {
			return step - 1;
		}

		return {
			goToStep: goToStep
		}
	}
);
