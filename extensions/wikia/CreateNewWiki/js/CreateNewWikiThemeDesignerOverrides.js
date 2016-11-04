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
		// The newValue is either the name of a theme or a single setting.
		// The latter should be handled as it is in the original method
		// or the theme settings will be overwritten (CE-456)
		if ('undefined' === typeof themes[newValue]) {
			ThemeDesigner.settings[setting] = newValue;
		} else {
			ThemeDesigner.settings = themes[newValue];
		}
	};

	/**
	 * Empty stub to prevent ThemeDesigner from saving state
	 *
	 * @returns {void}
	 */
	ThemeDesigner.save = function () {};
})();
