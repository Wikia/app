/*global define, require*/
/* jshint maxparams:false */
define('ext.wikia.adEngine.provider.ebay', [
	'wikia.log',
	'jquery',
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.geo'
], function (log, $, adContext, document, geo) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.ebay';

	function canHandleSlot(slotname) {
		return slotname === 'PREFOOTER_BOX_LEFT' || slotname === 'MOBILE_PREFOOTER';
	}

	function fillInSlot(slotname, pSuccess) {
		log(['fillInSlot', slotname], 'info', logGroup);

		var targeting = adContext.getContext().targeting,
			params = {
				skin: targeting.skin,
				title: document.title
			};


		if (geo) {
			params.geo = geo.getCountryCode();
		}

		log(['fillInSlot', slotname, 'Requesting ads', params], 'info', logGroup);

		$.nirvana.sendRequest({
			controller: 'AdProviderEbayController',
			method: 'centerWell',
			data: params,
			format: 'html',
			type: 'get',
			scripts: true,
			callback: function (data) {
				var slot = $('#' + slotname).html(data).addClass('ebay-ads').removeClass('default-height');

				if (targeting.pageType !== 'article') {
					slot.addClass('ebay-ads-responsive');
				}

				pSuccess();
			}
		});
	}

	return {
		name: 'Ebay',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
