/*global define*/
define('ext.wikia.adEngine.tracking.viewabilityTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, log, win) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.tracking.viewabilityTracker';

	function track(slot) {
		if (!context.opts.kikimoraViewabilityTracking) {
			log('Viewability tracking disabled', log.levels.info, logGroup);
			return;
		}

		var data,
			slotFirstChildData = slot.container.firstChild.dataset,
			slotParams = JSON.parse(slotFirstChildData.gptSlotParams);

		data = {
			'pv_unique_id': win.pvUID,
			'wsi': slotParams.wsi || '',
			'line_item_id': slotFirstChildData.gptLineItemId || '',
			'creative_id': slotFirstChildData.gptCreativeId || '',
			'rv': slotParams.rv || 1
		};

		log(['Slot viewable', slot.name, data], log.levels.info, logGroup);
		adTracker.trackDW(data, 'adengviewability');
	}

	return {
		track: track
	};
});
