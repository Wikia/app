/*global define*/
define('ext.wikia.adEngine.slot.interactiveMaps', ['wikia.document'], function(document) {
	'use strict';

	function initSlot(container) {
		var iframe = document.createElement('IFRAME');
		iframe.src = 'http://i4.rychu.wikia-dev.com/__cb1402920078/extensions/wikia/AdEngine/InteractiveMaps/ad.html';
		container.appendChild(iframe);
	}

	return {
		initSlot: initSlot
	};
});
