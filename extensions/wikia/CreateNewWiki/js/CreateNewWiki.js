require(['wikia.window', 'ext.createNewWiki.builder'], function (win, wikiBuilder) {
	'use strict';
	$(function() {
		win.wgAjaxPath = win.wgScriptPath + win.wgScript;
		wikiBuilder.init();

		if (win.wgOasisResponsive || win.wgOasisBreakpoints) {
			win.ThemeDesigner.slideByDefaultWidth = 500;
			win.ThemeDesigner.slideByItems = 3;
		} else {
			win.ThemeDesigner.slideByDefaultWidth = 608;
			win.ThemeDesigner.slideByItems = 4;
		}

		win.ThemeDesigner.themeTabInit();
	})
});
