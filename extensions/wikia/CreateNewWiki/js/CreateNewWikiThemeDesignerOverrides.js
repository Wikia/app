/* global ThemeDesigner, themes */

(function () {
	'use strict';
	/**
	 * @returns {void}
	 */
	ThemeDesigner.init = function () {
		$('#ThemeTab li label').remove();
		$('#ThemeTab div.slider img').bind('click', onThemeSelect);
	};

	function onThemeSelect() {
		require(['wikia.tracker'], function(tracker) {
			tracker.track({
				action: tracker.ACTIONS.CLICK,
				category: 'create-new-wiki',
				trackingMethod: 'analytics',
				label: 'theme-option-clicked'
			});
		});
	}

	/**
	 * @param {string} setting
	 * @param {string} newValue
	 *
	 * @returns {void}
	 */
	ThemeDesigner.set = function (setting, newValue) {
		var sassUrl;

		// The newValue is either the name of a theme or a single setting.
		// The latter should be handled as it is in the original method
		// or the theme settings will be overwritten (CE-456)
		if ('undefined' === typeof themes[newValue]) {
			ThemeDesigner.settings[setting] = newValue;
		} else {
			ThemeDesigner.settings = themes[newValue];
		}

		sassUrl = $.getSassCommonURL(
			'/skins/oasis/css/oasis.scss',
			$.extend(ThemeDesigner.settings, window.applicationThemeSettings)
		);

		$.getCSS(sassUrl, function (link) {
			$(ThemeDesigner.link).remove();
			ThemeDesigner.link = link;
		});

		// allow preview of theme background when chosen
		$('.WikiaPage').css('border', 0);
		$('.WikiaPageBackground').css('background', 'unset');
		$('.WikiaSiteWrapper').css('background-color', 'unset');
	};

	/**
	 * Empty stub to prevent ThemeDesigner from saving state
	 *
	 * @returns {void}
	 */
	ThemeDesigner.save = function () {};
})();
