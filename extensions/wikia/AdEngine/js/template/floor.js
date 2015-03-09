/*global define*/
define('ext.wikia.adEngine.template.footer', [
	'jquery',
	'wikia.log',
	'wikia.document',
	'wikia.iframeWriter',
	'wikia.window'
], function ($, log, doc, iframeWriter, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.floor',
		footerHtml = '<div id="ext-wikia-adEngine-template-footer">' +
			'<div class="background"></div>' +
			'<div class="ad"></div>' +
			'<a class="close" title="Close" href="#"><span>Close</span></a>' +
			'</div>';

	/**
	 * Show the footer ad
	 *
	 * @param {Object} params
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var $footer = $(footerHtml);

		win.WikiaBar.hideContainer();

		$footer.find('a.close').click(function (event) {
			event.preventDefault();
			$footer.hide();
		});

		$footer.find('.ad').append(iframeWriter.getIframe({
			code: params.code,
			width: params.width,
			height: params.height
		}));
		$(doc.body).append($footer);
	}

	return {
		show: show
	};
});
