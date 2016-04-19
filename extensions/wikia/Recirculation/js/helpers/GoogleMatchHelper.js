/*global define*/
define('ext.wikia.recirculation.helpers.googleMatch', [
	'jquery',
	'wikia.document',
	'wikia.window'
], function ($, document, window) {
	'use strict';

	var libraryLoaded = false;

	function loadGoogleMatch() {
		var googleScript,
			url = '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';

		if (libraryLoaded) {
			return;
		}

		window.adsbygoogle = window.adsbygoogle || []

		googleScript = document.createElement('script');
		googleScript.async = true;
		googleScript.src = url;
		document.getElementsByTagName('body')[0].appendChild(googleScript);

		libraryLoaded = true;
	}

	function injectGoogleMatchedContent(element) {
		var $ins,
			sass = window.wgSassParams;

		if (!libraryLoaded) {
			loadGoogleMatch();
		}

		$ins = $('<ins>', {
			'class': 'adsbygoogle recirculation-incontent',
			'data-ad-client': 'ca-pub-4086838842346968',
			'data-ad-slot': '7831067424',
			'data-color-link': sass['color-links'],
			'data-color-bg': sass['color-page'],
		});

		$(element).before($ins);

		window.adsbygoogle.push({});
	}

	return {
		injectGoogleMatchedContent: injectGoogleMatchedContent
	};
});
