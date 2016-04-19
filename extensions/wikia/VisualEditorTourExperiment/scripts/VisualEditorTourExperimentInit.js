define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'wikia.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
				category: 've-editing-tour',
				trackingMethod: 'analytics'
			}),
			LABEL_PREFIX_WITHOUTEDIT = 'userwithoutedit-',
			LABEL_PREFIX_NEW = 'newlyregistered-';

		function init() {
			if (isEnabled()) {
				clearEntrypointPopover();
				(new VETour(veTourConfig, getLabelPrefix())).start();
			}
		}

		function getLabelPrefix() {
			if (isNewlyregistered()) {
				return LABEL_PREFIX_NEW;
			} else if (isUserwithoutedit()) {
				return LABEL_PREFIX_WITHOUTEDIT;
			}
			return '';
		}

		function isEnabled() {
			return isExperimentVariation() &&
				(isNewlyregistered() || isUserwithoutedit()) &&
				!$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isExperimentVariation()) {
				if (isNewlyregistered()) {
					track({
						action: tracker.ACTIONS.SUCCESS,
						label: LABEL_PREFIX_WITHOUTEDIT + 'publish'
					});
				} else if (isUserwithoutedit()) {
					track({
						action: tracker.ACTIONS.SUCCESS,
						label: LABEL_PREFIX_NEW + 'publish'
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
			getLabelPrefix: getLabelPrefix,
			init: init,
			isEnabled: isEnabled,
			trackPublish: trackPublish
		};
	}
);
