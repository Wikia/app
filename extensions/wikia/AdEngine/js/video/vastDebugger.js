/*global define, JSON*/
define('ext.wikia.adEngine.video.vastDebugger', [
	'ext.wikia.adEngine.video.vastParser'
], function (vastParser) {
	'use strict';

	function setAttribute(element, attribute, value) {
		if (!element || !value) {
			return;
		}

		element.setAttribute(attribute, value);
	}

	function setVastAttributes(element, vastUrl, status, imaAd) {
		var vastParams = vastParser.parse(vastUrl, {
			imaAd: imaAd
		});

		setAttribute(element, 'data-gpt-content-type', vastParams.contentType);
		setAttribute(element, 'data-gpt-creative-id', vastParams.creativeId);
		setAttribute(element, 'data-gpt-line-item-id', vastParams.lineItemId);
		setAttribute(element, 'data-gpt-position', vastParams.position);
		setAttribute(element, 'data-gpt-size', vastParams.size);
		setAttribute(element, 'data-gpt-status', status);
		setAttribute(element, 'data-gpt-vast-params', JSON.stringify(vastParams.customParams));
	}

	return {
		setVastAttributes: setVastAttributes
	};
});
