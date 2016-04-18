define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest'],
	function ($, VETour, veTourConfig, abTest) {
		'use strict';

		function init() {
			if (abTest.inGroup('CONTRIB_EXPERIMENTS', 'VE_TOUR') &&
				($.cookie('newlyregistered') || $.cookie('userwithoutedit')) &&
				!$.cookie('vetourdismissed')
			) {
				(new VETour(veTourConfig)).start();
			}
		}

		return {
			init: init
		}
	}
);
