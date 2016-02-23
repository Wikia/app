'use strict';

require(['ponto', 'jquery'], function (ponto, $) {
	var $infoboxBuilderIframe = $('#infoboxBuilderIframe');

    $( window ).on('beforeunload', function() {
        return "If you leave this page, all your unsaved changes will be lost.";
    });

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
