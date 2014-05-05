(function (window, document) {
	'use strict';

	window.optimizelyUniqueExperiment = function (currentExperiment, mutuallyExclusiveExperiments) {
		if (window.optimizelyCachedExperiment) { return false; }
		
		var active, currentInCookie, key, allExperiments;

		if (mutuallyExclusiveExperiments) {
			active = mutuallyExclusiveExperiments;
		} else {
			active = [];
			allExperiments = window.optimizely.allExperiments;
			for (key in allExperiments) {
				if (allExperiments.hasOwnProperty(key) && ('enabled' in allExperiments[key]) && allExperiments[key]) {
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

		result = parseInt(currentInCookie, 10) === parseInt(currentExperiment, 10);
		
		if (result) {
			window.optimizelyCachedExperiment = currentExperiment;
		}
		
		return result;
	};

})(window, document);
