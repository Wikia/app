/*global define*/
define('ext.wikia.adEngine.slotTweaker', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.slot.adSlot',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (DOMElementTweaker, adSlot, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slotTweaker',
		defaultHeightClass = 'default-height',
		standardLeaderboardSizeClass = 'standard-leaderboard';

	function hide(slotname, useInline) {
		log('hide ' + slotname + ' using class hidden', 6, logGroup);
		DOMElementTweaker.hide(doc.getElementById(slotname), useInline);
	}

	function show(slotname) {
		log('show ' + slotname + ' removing class hidden', 6, logGroup);

		var slot = doc.getElementById(slotname);

		if (slot) {
			DOMElementTweaker.removeClass(slot, 'hidden');
		}
	}

	function removeDefaultHeight(slotname) {
		var slot = doc.getElementById(slotname);

		log('removeDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			DOMElementTweaker.removeClass(slot, defaultHeightClass);
		}
	}

	function isTopLeaderboard(slotname) {
		return slotname.indexOf('TOP_LEADERBOARD') !== -1;
	}

	function isStandardLeaderboardSize(slotname) {
		var slot = doc.getElementById(slotname),
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
		var slot = doc.getElementById(slotname);

		log('addDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			slot.className += ' ' + defaultHeightClass;
		}
	}

	function onReady(slotName, callback) {
		var iframe = adSlot.getIframe(slotName);

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

	function isBlockedElement(original) {
		return original.style.display === 'none';
	}

	function tweakRecoveredSlot(originalIframe, iframe) {
		var original = originalIframe,
			target = iframe;

		while(isBlockedElement(original)) {
			DOMElementTweaker.moveStylesToInline(original, target, ['paddingBottom', 'opacity']);
			target.style.display = 'block';

			original = original.parentNode;
			target = target.parentNode;
		}
	}

	function makeResponsive(slotName, aspectRatio) {
		var slot = doc.getElementById(slotName),
			providerContainer = adSlot.getProviderContainer(slotName);

		log(['makeResponsive', slotName, aspectRatio], 'info', logGroup);
		slot.classList.add('slot-responsive');

		onReady(slotName, function (iframe) {
			log(['makeResponsive', slotName], 'debug', logGroup);
			if (!aspectRatio) {
				var height = iframe.contentWindow.document.body.scrollHeight,
					width = iframe.contentWindow.document.body.scrollWidth;

				aspectRatio = width/height;
			}

			log(['Slot ratio', aspectRatio], 'debug', logGroup);
			providerContainer.style.paddingBottom = 100/aspectRatio + '%';
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

	function collapse(slotName, skipAnimation) {
		var slot = doc.getElementById(slotName);

		// make max-height consistent with expand()
		if (!skipAnimation) {
			slot.style.maxHeight = 2 * slot.scrollHeight + 'px';
			DOMElementTweaker.forceRepaint(slot);
		}
		DOMElementTweaker.removeClass(slot, 'expanded');
		DOMElementTweaker.addClass(slot, 'collapsed');
		DOMElementTweaker.addClass(slot, 'slot-animation');
		slot.style.maxHeight = '0';
	}

	function expand(slotName) {
		var slot = doc.getElementById(slotName);

		slot.style.maxHeight = slot.offsetHeight + 'px';
		DOMElementTweaker.removeClass(slot, 'hidden');
		DOMElementTweaker.removeClass(slot, 'collapsed');
		DOMElementTweaker.addClass(slot, 'expanded');
		DOMElementTweaker.addClass(slot, 'slot-animation');
		// make some space for slot content after page resize
		slot.style.maxHeight = 2 * slot.scrollHeight + 'px';
	}

	/**
	 * Triggers repaint to hide empty slot placeholders in Chrome
	 * This is a temporary workaround
	 * @param {string} slotId
	 */
	function hackChromeRefresh(slotId) {
		var slot = doc.getElementById(slotId),
			parent = slot && slot.parentElement;

		if (parent && slotId.match(/^INCONTENT/)) {
			parent.style.display = 'none';
			DOMElementTweaker.forceRepaint(parent);
			parent.style.display = '';
		}
	}

	return {
		addDefaultHeight: addDefaultHeight,
		adjustIframeByContentSize: adjustIframeByContentSize,
		collapse: collapse,
		expand: expand,
		hackChromeRefresh: hackChromeRefresh,
		hide: hide,
		isTopLeaderboard: isTopLeaderboard,
		makeResponsive: makeResponsive,
		onReady: onReady,
		removeDefaultHeight: removeDefaultHeight,
		show: show,
		tweakRecoveredSlot: tweakRecoveredSlot
	};
});
