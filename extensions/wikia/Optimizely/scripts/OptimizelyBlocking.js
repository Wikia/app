(function (window, document) {
	'use strict';

	window.optimizelyUniqueExperiment = function (currentExperiment, mutuallyExclusiveExperiments) {
		var active, currentInCookie, key;

		if (mutuallyExclusiveExperiments) {
			active = mutuallyExclusiveExperiments;
		} else {
			active = [];
			for (key in window.optimizely.allExperiments) {
				if ('enabled' in window.optimizely.allExperiments[key]) {
					active.push(key);
				}
			}
		}

		for (key = 0; key < active.length; key++) {
			if (document.cookie.indexOf(active[key]) > -1) {
				currentInCookie = active[key];
				break;
			}
		}

		currentInCookie = currentInCookie || active[Math.floor(Math.random() * active.length)];

		return currentInCookie === currentExperiment;
	};

})(window, document);
