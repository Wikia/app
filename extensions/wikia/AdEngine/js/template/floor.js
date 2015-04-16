/*global define*/
define('ext.wikia.adEngine.template.floor', [
	'ext.wikia.adEngine.adContext',
	require.optional('jquery'),
	'wikia.log',
	'wikia.document',
	'wikia.iframeWriter',
	'wikia.window'
], function (adContext, $, log, doc, iframeWriter, win) {
	'use strict';

	// Use our jQuery module or in Mercury Ember's jQuery
	$ = $ || win.$;

	var logGroup = 'ext.wikia.adEngine.template.floor',
		footerId = 'ext-wikia-adEngine-template-footer',
		oasisFooterHtml = '<div id="' + footerId + '">' +
			'<div class="background"></div>' +
			'<div class="ad"></div>' +
			'<a class="close" title="Close" href="#"><span>Close</span></a>' +
			'</div>',
		mercuryFooterHtml = '<div id="' + footerId + '">' +
			'<div class="background"></div>' +
			'<div class="ad"></div>' +
			'<a class="close" title="Close" href="#">' +
			'<svg role="img" class="ads-floor-close-button"><use xlink:href="#close"></use></svg>' +
			'</a>' +
			'</div>';

	/**
	 * Show the floor ad.
	 *
	 * You need to supply the HTML to put to the floor ad container and the desired dimensions
	 * of the container. The semi-transparent bar will be always 90px high, so the ad can stick out
	 * a little bit (for example if the desired container height is 100px).
	 *
	 * If you supply the onClick callback the code fires when you click within the iframe.
	 * Note the standard event bubbling applies, so it's possible some element within the iframe
	 * stops the event propagation. Flash will stop propagation for sure.
	 *
	 * @param {Object} params
	 * @param {string} params.code HTML code to put into floor container
	 * @param {number} params.width width of the ad to put into floor container
	 * @param {number} params.height width of the ad to put into floor container
	 * @param {number} [params.onClick] function to call when floor iframe is clicked
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var iframe = iframeWriter.getIframe({
				code: params.code,
				width: params.width,
				height: params.height
			}),
			skin = adContext.getContext().targeting.skin,
			$footer;

		if (skin === 'oasis') {
			$footer = $(oasisFooterHtml);
			win.WikiaBar.hideContainer();
		}

		if (skin === 'mercury') {
			$footer = $(mercuryFooterHtml);
		}

		$footer.find('a.close').click(function (event) {
			event.preventDefault();
			$footer.hide();
		});

		$footer.find('.ad').append(iframe);

		if (params.onClick) {
			$(iframe).on('load', function () {
				var iframeDoc = iframe.contentWindow.document;
				$('html', iframeDoc).css('cursor', 'pointer').on('click', params.onClick);
			});
		}

		$(doc.body).append($footer);
	}

	return {
		show: show
	};
});
