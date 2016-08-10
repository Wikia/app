define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var experimentName = 'contribution-experiments',
			freshlyRegisteredExperimentId = 5654433460,
			usersWithoutEditExperimentId = 5735670451;

		function init() {
			var lang = mw.config.get('wgUserLanguage');
			if (isEnabled()) {
				clearEntrypointPopover();
				(new VETour(veTourConfig[lang])).start();
			}
		}

		function isEnabled() {
			return isJapaneseCommunity() &&
				(isNewlyregistered() || isUserwithoutedit()) &&
				!$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isJapaneseCommunity() && (isNewlyregistered() || isUserwithoutedit())) {
				tracker.trackVerboseSuccess(experimentName, 'publish');
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isJapaneseCommunity() {
			return mw.config.get('wgContentLanguage') === 'ja';
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
