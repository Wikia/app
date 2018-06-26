/*global define*/
define('ext.wikia.adEngine.wad.ilRecLoader', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
], function (adContext, doc) {
	'use strict';

	var wikiaScriptToken = 'e7900721291bb9c31803e60f5441ca1c075df63f';

	function injectScript() {
		var scr = doc.createElement('script');

		scr.type = 'text/javascript';
		scr.src = 'https://www.nanovisor.io/@p1/client/abd/instart.js?token=' + wikiaScriptToken;

		doc.getElementsByTagName('head')[0].appendChild(scr);
	}

	function init() {
		if (adContext.get('opts.babRecovery')) {
			// ToDo: run on event
			injectScript();
		} else {
			injectScript();
		}
	}

	return {
		init: init
	};
});
