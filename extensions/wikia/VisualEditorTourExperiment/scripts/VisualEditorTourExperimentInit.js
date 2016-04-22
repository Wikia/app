define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var EXPERIMENT_NAME = 'contribution-experiments',
			EXPERIMENT_ID = 5654433460;

		function init() {
			if (isEnabled()) {
				clearEntrypointPopover();
				(new VETour(veTourConfig)).start();
			}
		}

		function isEnabled() {
			return isExperimentVariation() &&
				(isNewlyregistered() || isUserwithoutedit()) &&
				!$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isExperimentVariation() && (isNewlyregistered() || isUserwithoutedit())) {
				tracker.trackVerboseSuccess(EXPERIMENT_NAME, 'publish');
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isExperimentVariation() {
			return window.optimizely.variationNamesMap[EXPERIMENT_ID] === 'VE-TOUR';
		}

		function isNewlyregistered() {
			return $.cookie('newlyregistered');
		}

		function isUserwithoutedit() {
			return $.cookie('userwithoutedit');
		}

		return {
			init: init,
			isEnabled: isEnabled,
			trackPublish: trackPublish
		};
	}
);
