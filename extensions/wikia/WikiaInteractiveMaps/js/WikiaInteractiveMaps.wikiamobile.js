require(['wikia.window', 'ponto'], function(w, ponto) {
	'use strict';

	console.log('client', Date.now());

	var iframe =  w.document.getElementsByName('wikia-interactive-map')[0];

	if (iframe) {
		ponto.setTarget(Ponto.TARGET_IFRAME, '*', iframe.contentWindow);
		iframe.src = iframe.dataset.url;
	}
});
