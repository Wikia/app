/*global define*/
define('ext.wikia.adEngine.utils.cssTweaker', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.utils.cssTweaker';

	/**
	 * Create cssText based on computedStyle
	 * Custom method because of Firefox bug #137687
	 */
	function getComputedStyleCssText(element) {
		var style = window.getComputedStyle(element),
			cssText;

		if (style.cssText !== '') {
			return style.cssText;
		}

		cssText = '';
		for (var i = 0; i < style.length; i++) {
			cssText += style[i] + ':' + style.getPropertyValue(style[i]) + ';';
		}

		return cssText;
	}

	function copyStyles(from, to) {
		log(['copyStyles', from, to], 'debug', logGroup);
		var source = doc.getElementById(from),
			destination = doc.getElementById(to);

		if (source && destination) {
			destination.style.cssText = getComputedStyleCssText(source);
		}
	}

	return {
		copyStyles: copyStyles
	};
});
