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
			var enable = isJapaneseCommunity;
			if (mw.config.get('wgUserName') != null){
				enable = enable && isUserLanguagePreferenceJapanese() && isUserwithoutedit();
			}
			return enable && !$.cookie('vetourdisabled');
		}

		function trackPublish() {
			if (isJapaneseCommunity()) {
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

		function isUserLanguagePreferenceJapanese() {
			return mw.config.get('wgUserLanguage') === 'ja';
		}

		return {
			init: init,
			isEnabled: isEnabled,
			trackPublish: trackPublish
		};
	}
);
