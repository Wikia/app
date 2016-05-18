/* global mw, ThemeDesigner */

$(function () {
	'use strict';
	window.wgAjaxPath = window.wgScriptPath + window.wgScript;
	mw.loader.using('wikia.stringhelper')
		.done(function () {
			require(
				[
					'wikia.stringhelper',
					'WikiBuilder'
				], function (stringHelper, wikiBuilder) {
					wikiBuilder.init(stringHelper);
				}
			);
		});

	if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
		ThemeDesigner.slideByDefaultWidth = 500;
		ThemeDesigner.slideByItems = 3;

	} else {
		ThemeDesigner.slideByDefaultWidth = 608;
		ThemeDesigner.slideByItems = 4;
	}
	ThemeDesigner.themeTabInit();
});
