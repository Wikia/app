/*global define*/
define('ext.wikia.adEngine.template.interstitial', [
	'wikia.document',
	'wikia.log',
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.interstitial',
		slotName = 'INVISIBLE_HIGH_IMPACT_2',
		wrapper = doc.getElementById('InvisibleHighImpactWrapper');

	function show() {
		wrapper.querySelector('.close').addEventListener('click', function (event) {
			event.preventDefault();

			wrapper.classList.add('hidden');
			doc.documentElement.classList.remove('stop-scrolling');

			log('Hide interstitial', 'info', logGroup);
		});

		wrapper.classList.add('interstitial');
		wrapper.classList.remove('hidden');
		doc.documentElement.classList.add('stop-scrolling');

		log('Show interstitial', 'info', logGroup);
	}

	return {
		show: show
	};
});
