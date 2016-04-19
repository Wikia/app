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
			return (isNewlyregistered() || isUserwithoutedit()) && !$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isNewlyregistered()) {
				track({
					action: tracker.ACTIONS.SUCCESS,
					label: 'publish-newlyregistered'
				});
			} else if (isUserwithoutedit()) {
				track({
					action: tracker.ACTIONS.SUCCESS,
					label: 'publish-userwithoutedit'
				});
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isNewlyregistered() {
			return abTest.inGroup('CONTRIB_EXPERIMENTS', 'VE_TOUR_NEWLYREGISTERED') && $.cookie('newlyregistered');
		}
		
		function isUserwithoutedit() {
			return abTest.inGroup('CONTRIB_EXPERIMENTS', 'VE_TOUR_USERWITHOUTEDIT') && $.cookie('userwithoutedit');
		}

		return {
			init: init,
			isEnabled: isEnabled,
			trackPublish: trackPublish
		}
	}
);
