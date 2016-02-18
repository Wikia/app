/*global define*/
define('ext.wikia.recirculation.GoogleMatchHelper', [
	'wikia.document',
	'wikia.window'
], function (document, window) {
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
		var matchedContent,
			sass = window.wgSassParams;

		if (!libraryLoaded) {
			loadGoogleMatch();
		}

		matchedContent = document.createElement('ins');
		matchedContent.className = 'adsbygoogle recirculation-rail';
		matchedContent.style.display = 'block';
		matchedContent.dataset.adClient = "ca-pub-4086838842346968";
		matchedContent.dataset.adSlot = "7831067424";
		matchedContent.dataset.adFormat = "autorelaxed";
		matchedContent.dataset.colorLink = sass['color-links'];
		matchedContent.dataset.colorBg = sass['color-page'];

		$(element).append(matchedContent);

		window.adsbygoogle.push({});
	}

	return {
		injectGoogleMatchedContent: injectGoogleMatchedContent
	};
});
