/*global define*/
define('ext.wikia.adEngine.slot.service.actionHandler',  [
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.slot.service.viewabilityHandler',
	'wikia.abTest',
	'wikia.log'
], function (messageListener, slotTweaker, viewabilityHandler, abTest, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.service.actionHandler';

	function messageCallback(data) {
		if (!data.slotName) {
			return log('messageCallback: missing slot name', log.levels.debug, logGroup);
		}

		switch (data.action) {
			case 'expand':
				slotTweaker.expand(data.slotName);
				break;
			case 'collapse':
				slotTweaker.collapse(data.slotName);
				break;
			case 'hide':
				slotTweaker.hide(data.slotName);
				break;
			case 'show':
				slotTweaker.show(data.slotName);
				break;
			case 'make-responsive':
				slotTweaker.makeResponsive(data.slotName, data.aspectRatio);
				break;
			case 'refresh-on-view':
				if (!abTest.getGroup('AD_MIX') || (abTest.getGroup('AD_MIX') && abTest.getGroup('AD_MIX').indexOf('AD_MIX_1') === 0)) { // Don't refresh ad by creative if in AD_MIX_1 and AD_MIX_1B AB test
					viewabilityHandler.refreshOnView(data.slotName, data.delay);
				}
				break;
			default:
				log(['messageCallback: unknown action', data.action], log.levels.debug, logGroup);
		}
	}

	function registerMessageListener() {
		messageListener.register({dataKey: 'action', infinite: true}, messageCallback);
	}

	return {
		registerMessageListener: registerMessageListener
	};
});
