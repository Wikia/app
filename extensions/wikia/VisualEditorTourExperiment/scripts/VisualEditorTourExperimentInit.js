define('VisualEditorTourExperimentInit',
	['VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest'],
	function (VETour, veTourConfig, abTest) {
		'use strict';

		function init() {
			if (abTest.inGroup('CONTRIB_EXPERIMENTS', 'VE_TOUR')) {
				(new VETour(veTourConfig)).start();
			}
		}

		return {
			init: init
		}
	}
);
