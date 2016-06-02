/*global define*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adHelper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adHelper, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfaa',
		// SCSS property: $breakpoint-width-not-supported
		breakPointWidthNotSupported = 767,
		nav = doc.getElementById('globalNavigation'),
		page = doc.getElementsByClassName('WikiaSiteWrapper')[0],
		wrapper = doc.getElementById('WikiaTopAds');

	function updateNavBar(height) {
		var position = win.pageYOffset;

		if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
			wrapper.classList.add('bfaa-pinned-nav');
			nav.classList.add('bfaa-pinned');
		} else {
			wrapper.classList.remove('bfaa-pinned-nav');
			nav.classList.remove('bfaa-pinned');
		}
	}

	function show(params) {
		var backgroundColor = params.backgroundColor ? '#' + params.backgroundColor.replace('#', '') : '#000',
			height = params.height || 0;

		nav.style.top = '';
		page.classList.add('bfaa-template');
		wrapper.style.background = backgroundColor;

		updateNavBar(height);
		doc.addEventListener('scroll', adHelper.throttle(function () {
			updateNavBar(height);
		}, 100));

		if (win.WikiaBar) {
			win.WikiaBar.hideContainer();
		}

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
