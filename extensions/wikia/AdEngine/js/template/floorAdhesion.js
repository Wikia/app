/*global define*/
define('ext.wikia.adEngine.template.floorAdhesion', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adContext, slotTweaker, log, doc, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.floorAdhesion',
		slotName = 'INVISIBLE_HIGH_IMPACT_2',
		wrapper = doc.getElementById('InvisibleHighImpactWrapper');

	function show() {
		var skin = adContext.getContext().targeting.skin;

		wrapper.querySelector('.close').addEventListener('click', function (event) {
			event.preventDefault();
			wrapper.classList.add('hidden');
		});

		if (skin === 'oasis') {
			win.WikiaBar.hideContainer();
		}

		wrapper.classList.add('floor-adhesion');
		wrapper.classList.remove('hidden');

		slotTweaker.adjustIframeByContentSize(slotName);

		log('Show floor adhesion', 'info', logGroup);
	}

	return {
		show: show
	};
});
