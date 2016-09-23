'use strict';

require(['ponto', 'jquery'], function (ponto, $) {
	var $infoboxBuilderIframe = $('#infoboxBuilderIframe');

	if ($infoboxBuilderIframe.length) {
		ponto.setTarget(
			Ponto.TARGET_IFRAME,
			window.location.origin,
			$infoboxBuilderIframe[0].contentWindow
		);

		// load <iframe> content after ponto is set up
		$infoboxBuilderIframe.attr('src', $infoboxBuilderIframe.data('src'));

	}
});
