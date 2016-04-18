define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'wikia.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
			category: 've-editing-tour',
			trackingMethod: 'analytics'
		});

		function init() {
			if (isEnabled()) {
				clearEntrypointPopover();
				(new VETour(veTourConfig)).start();
			}
		}

		function isEnabled() {
			return isExperimentVariation() &&
				(isNewlyregistered() || isUserwithoutedit) &&
				!$.cookie('vetourdismissed');
		}

		function trackPublish() {
			if (isExperimentVariation()) {
				if (isNewlyregistered()) {
					track({
						action: tracker.ACTIONS.SUCCESS,
						label: 'publish-userwithoutedit'
					});
				} else if (isUserwithoutedit()) {
					track({
						action: tracker.ACTIONS.SUCCESS,
						label: 'publish-newlyregistered'
					});
				}
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isExperimentVariation() {
			return abTest.inGroup('CONTRIB_EXPERIMENTS', 'VE_TOUR');
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
		}
	}
);
