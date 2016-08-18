define('VisualEditorTourExperimentInit',
	['jquery', 'VisualEditorTourExperiment', 'VisualEditorTourExperimentConfig', 'wikia.abTest', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, VETour, veTourConfig, abTest, tracker) {
		'use strict';

		var experimentName = 'contribution-experiments';


		function init() {
			var lang = mw.config.get('wgUserLanguage');
			if (isEnabled()) {
				clearEntrypointPopover();
				(new VETour(veTourConfig[lang])).start();
			}
		}

		function isEnabled() {
			return isAllowedCommunity() &&
				(isNewlyregistered() || isUserwithoutedit()) &&
				!$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isAllowedCommunity() && (isNewlyregistered() || isUserwithoutedit())) {
				tracker.trackVerboseSuccess(experimentName, 'publish');
			}
		}

		function clearEntrypointPopover() {
			$('#ca-ve-edit').popover('destroy');
		}

		function isAllowedCommunity() {
			var allowedLanguages = ['ja','es','de'];
			return allowedLanguages.indexOf(mw.config.get('wgContentLanguage')) > -1;
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
