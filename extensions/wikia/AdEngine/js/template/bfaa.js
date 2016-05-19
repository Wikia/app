/*global define*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adHelper',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adHelper, log, doc, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfaa',
		// SCSS property: $breakpoint-width-not-supported
		breakPointWidthNotSupported = 767,
		nav = doc.getElementById('globalNavigation'),
		page = doc.querySelector('.WikiaSiteWrapper'),
		wrapper = doc.getElementById('WikiaTopAds');

	function updateNavBar(height) {
		var position = doc.body.scrollTop;

		if (doc.body.offsetWidth <= breakPointWidthNotSupported) {
			return;
		}

		if (position > height) {
			nav.classList.remove('bfaa-pinned');
		} else {
			nav.classList.add('bfaa-pinned');
		}
	}

	function show(params) {
		var backgroundColor = params.backgroundColor ? '#' + params.backgroundColor.replace('#', '') : '#000',
			height = params.height || 0;

		page.classList.add('bfaa-template');
		wrapper.style.background = backgroundColor;

		updateNavBar(height);
		doc.addEventListener('scroll', adHelper.throttle(function () {
			updateNavBar(height);
		}));

		if (win.WikiaBar) {
			win.WikiaBar.hideContainer();
		}

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
