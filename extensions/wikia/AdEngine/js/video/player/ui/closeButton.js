/* global define */
define('ext.wikia.adEngine.video.player.ui.closeButton', [], function () {
	'use strict';

	var className = 'close-ad';

	function create(ad) {
		var element = document.createElement('div');
		element.classList.add(className);

		element.addEventListener('click', function () {
			ad.adsManager.stop();
		});

		return element;
	}

	return {
		create: create
	};
});
