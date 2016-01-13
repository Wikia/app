/*global define*/
define('ext.wikia.adEngine.taboolaHelper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.window'
], function (adContext, document, win) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.taboolaHelper',
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
		win._taboola = win._taboola || [];
		win._taboola.push(taboolaInit);
		win._taboola.push({flush: true});

		taboolaScript = document.createElement('script');
		taboolaScript.async = true;
		taboolaScript.src = url;
		taboolaScript.id = logGroup;
		document.getElementsByTagName('body')[0].appendChild(taboolaScript);

		libraryLoaded = true;
	}

	function initializeWidget ( widget ) {
		if (!libraryLoaded) {
			loadTaboola();
		}

		win._taboola.push( widget );
	}

	return {
		initializeWidget: initializeWidget,
		loadTaboola: loadTaboola
	};
});
