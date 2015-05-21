/**
 * Experimental ad provider for OpenX. It loads the OpenX code in a (non-GPT) iframe.
 * To preview how it would work, use ?forceopenx=1 URL param
 *
 * Corresponding DFP Lines (ztest OpenX CC ** Entertainment INTL):
 *
 * INCONTENT_BOXAD_1: https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112107492
 * TOP_LEADERBOARD:   https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112107612
 * TOP_RIGHT_BOXAD:   https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112107132
 * PREFOOTER:         https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112107252
 * LEFT_SKYSCRAPER:   https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112107372
 * MOBILE_TOP_LEADER: https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112963692
 * MOBILE_PREFOOTER:  https://www.google.com/dfp/5441#delivery/LineItemDetail/orderId=268596372&lineItemId=112963932
 */

/*global define*/
define('ext.wikia.adEngine.provider.openX', [
	'ext.wikia.adEngine.provider.openX.targeting',
	'wikia.document',
	'wikia.iframeWriter',
	'wikia.log'
], function (targeting, doc, iframeWriter, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.openX';

	function canHandleSlot(slotName) {
		var result = !!targeting.getItem(slotName);

		log(['canHandleSlot', slotName, result], 'info', logGroup);
		return result;
	}

	function getCode(auid) {
		log(['getCode', auid], 'info', logGroup);

		var firstScript = '<script>OX_ads = ' + JSON.stringify([{auid: auid}]) + ';</script>',
			secondScript = '<script src="http://ox-d.wikia.servedbyopenx.com/w/1.0/jstag"></script>';

		log(['getCode', firstScript, secondScript], 'info', logGroup);

		return firstScript + secondScript;
	}

	function fillInSlot(slotName, success) {
		log(['fillInSlot', slotName], 'info', logGroup);

		var slot = doc.getElementById(slotName),
			slotItem = targeting.getItem(slotName),
			size = slotItem.size.split('x'),
			width = size[0],
			height = size[1];

		slot.appendChild(iframeWriter.getIframe({
			code: getCode(slotItem.auid),
			width: width,
			height: height
		}));
		success();
	}

	return {
		name: 'OpenX',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
