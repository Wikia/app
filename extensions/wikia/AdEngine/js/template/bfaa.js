/*global define*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adContext, adHelper, log, doc, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfaa',
		height = 0,
		scrollListener = null,
		nav = doc.getElementById('globalNavigation') || doc.querySelector('.site-head'),
		page = doc.getElementById('WikiaPage') || doc.querySelector('.wiki-container'),
		wrapper = doc.getElementById('WikiaTopAds') || doc.querySelector('.mobile-top-leaderboard');

	function updateNavBar() {
		var position = doc.body.scrollTop,
			style = win.getComputedStyle(nav);

		page.style.marginTop = (height - 2) + 'px';

		if (style.getPropertyValue('position') === 'relative') {
			nav.style.top = height + 'px';
			return;
		}

		if (position > height) {
			nav.style.top = 0;
			nav.style.position = 'fixed';
		} else {
			nav.style.top = height + 'px';
			nav.style.position = 'absolute';
		}
	}

	function show(params) {
		var backgroundColor = params.backgroundColor ? '#' + params.backgroundColor.replace('#', '') : '#000';

		height = params.height || 0;

		wrapper.classList.add('bfaa-template');
		wrapper.style.background = backgroundColor;

		updateNavBar();
		scrollListener = adHelper.throttle(updateNavBar);
		doc.addEventListener('scroll', scrollListener);

		if (win.WikiaBar) {
			win.WikiaBar.hideContainer();
		}

		log('show', 'info', logGroup);
	}

	function getSize() {
		return height;
	}

	adContext.addCallback(function () {
		doc.removeEventListener('scroll', scrollListener);
		height = 0;
		wrapper.classList.remove('bfaa-template');
		wrapper.style.background = '';
		nav.style.top = '';
		nav.style.position = '';
		page.style.marginTop = '';
	});

	return {
		getSize: getSize,
		show: show
	};
});
