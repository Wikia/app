/*global define*/
define('ext.wikia.adEngine.taboolaHelper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document'
], function (adContext, document) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.taboola',
		libraryLoaded = false,
		pageType = context.targeting.pageType;

	function loadTaboola() {
		var taboolaInit = {},
			taboolaScript,
			url = '//cdn.taboola.com/libtrc/wikia-network/loader.js';

		if (libraryLoaded) {
			return;
		}

		taboolaInit[pageType] = 'auto';
		window._taboola = window._taboola || [];
		window._taboola.push(taboolaInit);
		window._taboola.push({flush: true});

		taboolaScript = document.createElement('script');
		taboolaScript.async = true;
		taboolaScript.src = url;
		taboolaScript.id = logGroup;
		document.getElementsByTagName('body')[0].appendChild(taboolaScript);

		libraryLoaded = true;
	}

	return {
		libraryLoaded: libraryLoaded,
		loadTaboola: loadTaboola
	};
});
