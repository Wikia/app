define('wikia.infoboxBuilder.templateClassificationHelper', ['wikia.window', 'jquery'], function (win, $) {
	'use strict';

	/**
	 * @desc checks if infobox builder should be used instead of regular editor
	 * This method won't return true if `$wgEnablePortableInfoboxBuilderExt === false`
	 * because `win.isTemplateBodySupportedInfobox` is set in `PortableInfoboxBuilderHooks::isTemplateBodySupportedInfobox`
	 *
	 * @param {String} newTemplateType - choosen template type
	 * @param {String} modalMode - mode in which modal was opened
	 * @returns {Boolean}
	 */
	function shouldRedirectToInfoboxBuilder(newTemplateType, modalMode) {
		return win.infoboxBuilderPath &&
			win.isTemplateBodySupportedInfobox &&
			newTemplateType === 'infobox' &&
			modalMode === 'addTemplate';
	}

	/**
	 * @desc redirects to infobox builder tool
	 */
	function redirectToInfoboxBuilder() {
		var infoboxBuilderPath = win.infoboxBuilderPath;

		if (infoboxBuilderPath) {
			win.location = infoboxBuilderPath;
		}
	}

	/**
	 * @desc removes special class from WikiaPage wrapper to show hidden editor
	 */
	function showHiddenEditor() {
		var tcBodyClassName = win.tcBodyClassName;

		if (tcBodyClassName) {
			$('body').removeClass(tcBodyClassName);
		}
	}

	return {
		shouldRedirectToInfoboxBuilder: shouldRedirectToInfoboxBuilder,
		redirectToInfoboxBuilder: redirectToInfoboxBuilder,
		showHiddenEditor: showHiddenEditor
	}
});
