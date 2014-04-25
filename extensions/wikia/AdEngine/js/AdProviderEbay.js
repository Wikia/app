/*global define, require*/
/* jshint maxparams:false */
define('ext.wikia.adEngine.provider.ebay', [
	'wikia.log',
	'jquery',
	'wikia.window',
	'wikia.document',
	'wikia.geo'
], function (log, $, window, document, geo) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.ebay';

	function canHandleSlot(slotname) {
		return slotname === 'PREFOOTER_BOX_LEFT' || slotname === 'MOBILE_PREFOOTER';
	}

	function fillInSlot(slotname, pSuccess) {
		log(['fillInSlot', slotname], 'info', logGroup);

		var params = {
				skin: window.skin,
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
				$('#' + slotname).html(data).removeClass('default-height');

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
