define('ext.wikia.curatedTour.tourNavigator',
	[
		'jquery',
		'wikia.cookies'
	],
	function ($, cookies) {
		"use strict";

		function goToStep(step) {
			var index = getIndexFromStep(step);


		}

		function getIndexFromStep(step) {
			return step - 1;
		}

		return {
			goToStep: goToStep
		}
	}
);
