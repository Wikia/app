/*global define*/
define('ext.wikia.adEngine.slotTweaker', [
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (log, document, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slotTweaker',
		defaultHeightClass = 'default-height',
		rclass = /[\t\r\n]/g,
		standardLeaderboardSizeClass = 'standard-leaderboard';

	function removeClass(element, cls) {
		var oldClasses,
			newClasses = ' ' + element.className.replace(rclass, ' ') + ' ';

		// Remove all instances of class in the className string
		while (oldClasses !== newClasses) {
			oldClasses = newClasses;
			newClasses = oldClasses.replace(' ' + cls + ' ', ' ');
		}

		log(['removeClass ' + cls, element], 8, logGroup);
		element.className = newClasses;
	}

	function hide(slotname, useInline) {
		log('hide ' + slotname + ' using class hidden', 6, logGroup);

		var slot = document.getElementById(slotname);

		if (slot && useInline) {
			slot.style.display = 'none';
		} else if (slot) {
			removeClass(slot, 'hidden');
			slot.className += ' hidden';
		}
	}

	function show(slotname) {
		log('show ' + slotname + ' removing class hidden', 6, logGroup);

		var slot = document.getElementById(slotname);

		if (slot) {
			removeClass(slot, 'hidden');
		}
	}

	function removeDefaultHeight(slotname) {
		var slot = document.getElementById(slotname);

		log('removeDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			removeClass(slot, defaultHeightClass);
		}
	}

	function isLeaderboard(slotname) {
		return slotname.indexOf('LEADERBOARD') !== -1;
	}

	function isStandardLeaderboardSize(slotname) {
		var slot = document.getElementById(slotname),
			isStandardSize;

		if (slot) {
			isStandardSize = slot.offsetHeight >= 90 && slot.offsetHeight <= 95 && slot.offsetWidth <= 728;

			log(
				['isStandardLeaderboardSize', slotname, slot.offsetWidth + 'x' + slot.offsetHeight, isStandardSize],
				3,
				logGroup
			);

			return isStandardSize;
		}
		log('isStandardLeaderboardSize: ' + slotname + ' missing', 3, logGroup);
	}

	function addDefaultHeight(slotname) {
		var slot = document.getElementById(slotname);

		log('addDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			slot.className += ' ' + defaultHeightClass;
		}
	}

	// TODO: fix it, it's a hack!
	function adjustLeaderboardSize(slotname) {
		var slot = document.getElementById(slotname);
		if (isLeaderboard(slotname) && isStandardLeaderboardSize(slotname)) {
			slot.className += ' ' + standardLeaderboardSizeClass;
		}
	}

	// TODO: fix it, it's a hack!
	function removeTopButtonIfNeeded(slotname) {
		if (isLeaderboard(slotname) && !isStandardLeaderboardSize(slotname)) {
			log('removing TOP_BUTTON_WIDE', 3, logGroup);
			hide('TOP_BUTTON_WIDE');
		}
		if (isLeaderboard(slotname) && isStandardLeaderboardSize(slotname)) {
			log('pushing TOP_BUTTON_WIDE.force to Liftium2 queue', 2, logGroup);
			window.adslots2.push('TOP_BUTTON_WIDE.force');
		}
	}

	function onReady(slotName, callback) {
		var iframe = document.getElementById(slotName).querySelector('div:not(.hidden) > div[id*="_container_"] iframe');

		if (!iframe) {
			log('onIframeReady - iframe does not exist', 'debug', logGroup);
			return;
		}

		if (iframe.contentWindow.document.readyState === 'complete') {
			callback(iframe);
		} else {
			iframe.addEventListener('load', function () {
				callback(iframe);
			});
		}
	}

	function makeResponsive(slotName) {
		var providerContainer = document.getElementById(slotName).lastElementChild;

		onReady(slotName, function (iframe) {
			var height = iframe.contentWindow.document.body.offsetHeight,
				width = iframe.contentWindow.document.body.offsetWidth;

			providerContainer.style.paddingBottom = 100/(width/height) + '%';
		});
	}

	function adjustIframeByContentSize(slotName) {
		onReady(slotName, function (iframe) {
			var height = iframe.contentWindow.document.body.scrollHeight,
				width = iframe.contentWindow.document.body.scrollWidth;

			iframe.width = width;
			iframe.height = height;
			log(['adjustIframeByContentSize', slotName, width, height], 'debug', logGroup);
		});
	}

	function noop() {
		return;
	}

	/**
	 * Triggers repaint to hide empty slot placeholders in Chrome
	 * This is a temporary workaround
	 * @param {string} slotId
	 */
	function hackChromeRefresh(slotId) {
		var slot = document.getElementById(slotId),
			parent = slot && slot.parentElement;

		if (parent && slotId.match(/^INCONTENT/)) {
			parent.style.display = 'none';
			noop(parent.offsetHeight);
			parent.style.display = '';
		}
	}

	return {
		addDefaultHeight: addDefaultHeight,
		adjustIframeByContentSize: adjustIframeByContentSize,
		adjustLeaderboardSize: adjustLeaderboardSize,
		hackChromeRefresh: hackChromeRefresh,
		hide: hide,
		makeResponsive: makeResponsive,
		removeDefaultHeight: removeDefaultHeight,
		removeTopButtonIfNeeded: removeTopButtonIfNeeded,
		show: show
	};
});
