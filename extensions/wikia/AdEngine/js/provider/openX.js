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
	'wikia.document',
	'wikia.iframeWriter',
	'wikia.log'
], function (doc, iframeWriter, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.openX',
		slotMap = {
			'HOME_TOP_LEADERBOARD':   {size: '728x90',  auid: 537201006},
			'HOME_TOP_RIGHT_BOXAD':   {size: '300x250', auid: 537200993},
			'INCONTENT_BOXAD_1':      {size: '300x250', auid: 537201005},
			'INCONTENT_1A':           {size: '300x250', auid: 537200993},
			'INCONTENT_1B':           {size: '300x250', auid: 537200993},
			'INCONTENT_1C':           {size: '300x250', auid: 537200993},
			'LEFT_SKYSCRAPER_2':      {size: '160x600', auid: 537200991},
			'LEFT_SKYSCRAPER_3':      {size: '160x600', auid: 537200991},
			'MOBILE_IN_CONTENT':      {size: '300x250', auid: 537208059},
			'MOBILE_PREFOOTER':       {size: '300x250', auid: 537208059},
			'MOBILE_TOP_LEADERBOARD': {size: '320x50',  auid: 537208060},
			'PREFOOTER_LEFT_BOXAD':   {size: '300x250', auid: 537201004},
			'PREFOOTER_RIGHT_BOXAD':  {size: '300x250', auid: 537201004},
			'TOP_LEADERBOARD':        {size: '728x90',  auid: 537201006},
			'TOP_RIGHT_BOXAD':        {size: '300x250', auid: 537200993}
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName, !!slotMap[slotName]], 'info', logGroup);
		return (!!slotMap[slotName]);
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
			slotItem = slotMap[slotName],
			size = slotItem.size.split('x'),
			width = size[0],
			height = size[1],
			iframe = iframeWriter.getIframe({
				code: getCode(slotItem.auid),
				width: width,
				height: height
			});

		slot.appendChild(iframe);
		// Prevent from forever ads loading
		iframe.contentWindow.document.close();
		success();
	}

	return {
		name: 'OpenX',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
