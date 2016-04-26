define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var experimentName = 'contribution-experiments',
			freshlyRegisteredExperimentId = 5654433460,
			usersWithoutEditExperimentId = 5735670451;

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
				tracker.trackVerboseSuccess(experimentName, 'publish');
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isExperimentVariation() {
			return window.optimizely && (
					window.optimizely.variationNamesMap[freshlyRegisteredExperimentId] === 'VE-TOUR' ||
					window.optimizely.variationNamesMap[usersWithoutEditExperimentId] === 'VE-TOUR'
				);
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
