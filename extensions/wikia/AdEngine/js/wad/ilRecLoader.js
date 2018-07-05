/*global define*/
define('ext.wikia.adEngine.wad.ilRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.window'
], function (adContext, scriptLoader, doc, win) {
	'use strict';

	function injectScript() {
		if (win.runILCode) {
			win.runILCode();
		}
	}

	function init() {
		doc.addEventListener('bab.blocking', injectScript);
	}

	return {
		init: init
	};
});
