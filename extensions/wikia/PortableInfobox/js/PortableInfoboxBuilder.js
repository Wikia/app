'use strict';

require(['ponto', 'jquery'], function (ponto, $) {
	var infoboxBuilderIframe = $('#infoboxBuilderIframe');

	if (infoboxBuilderIframe.length) {
		ponto.setTarget(
			Ponto.TARGET_IFRAME,
			window.location.origin,
			infoboxBuilderIframe[0].contentWindow
		);
	}
});
