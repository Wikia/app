/*global define*/
/* jshint maxparams:false */
define('ext.wikia.adEngine.provider.ebay', [
	'wikia.log',
	'jquery',
	'wikia.window'
], function (log, $, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.ebay';

	function canHandleSlot(slotname) {
		return slotname === 'PREFOOTER_BOX_LEFT' || slotname === 'MOBILE_PREFOOTER';
	}

	function fillInSlot(slotname, pSuccess) {
		log(['fillInSlot', slotname], 'info', logGroup);

		var params = {
			skin: window.skin
		};

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
