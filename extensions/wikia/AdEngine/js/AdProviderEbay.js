/*global define*/
/* jshint maxparams:false */
define('ext.wikia.adEngine.provider.ebay', [
	'wikia.log',
	'jquery'
], function (log, $) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.ebay';

	function canHandleSlot(slotname) {
		return slotname === 'PREFOOTER_BOX_LEFT';
	}

	function fillInSlot(slotname, pSuccess, pHop) {
		log(['fillInSlot', slotname], 'info', logGroup);

		var params = {};

		$.nirvana.sendRequest({
			controller: 'AdProviderEbayController',
			method: 'centerWell',
			data: params,
			format: 'html',
			type: 'get',
			callback: function (data) {
				$('#' + slotname).html(data);
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
