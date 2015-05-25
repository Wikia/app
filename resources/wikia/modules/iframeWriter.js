/*global define*/
define('wikia.iframeWriter', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'wikia.iframeWriter',
		iframeStyle = '<style>* {margin: 0; padding: 0;}</style>',
		iframeHeader = '<html><body>',
		iframeFooter = '</body></html>';

	/**
	 * Get iframe with given HTML written in it
	 *
	 * @param {Object} params
	 * @param {string} params.code - code to put into the iframe
	 * @param {number} params.width - desired width of the iframe
	 * @param {number} params.height - desired height of the iframe
	 * @param {string} [params.classes] - custom class(es) of the iframe (space-separated if more than one)
	 */
	function getIframe(params) {
		log(['getIframe', params], 'debug', logGroup);

		var code = iframeHeader + iframeStyle + params.code + iframeFooter,
			iframe = doc.createElement('iframe');

		iframe.frameBorder = 'no';
		iframe.scrolling = 'no';
		iframe.width = params.width;
		iframe.height = params.height;

		if (params.classes) {
			iframe.className = params.classes;
		}

		iframe.onload = function () {
			iframe.contentWindow.document.write(code);
		};

		return iframe;
	}

	return {
		getIframe: getIframe
	};
});
