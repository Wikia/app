require(['wikia.window', 'wikia.intMap.pontoBridge'], function(w, pontoBridge) {
	'use strict';

	var iframe =  w.document.getElementsByName('wikia-interactive-map')[0];

	if (iframe) {
		pontoBridge.init(iframe);
	}
});
