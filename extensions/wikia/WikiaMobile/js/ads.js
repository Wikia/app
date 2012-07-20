/**
 * Module used to handle ads on wikiamobile
 * closing it and keeping it on the screen
 *
 * @define ads
 * @require events
 *
 * @author Jakub Olek
 */
/*global window, document, define, setTimeout,
setInterval, clearInterval, Modernizr*/

define('ads', ['events'], function (ev) {
	'use strict';

	var d = document,
		adSlot,
		adSlotStyle,
		w,
		ftr;

	function moveSlot(plus) {
		if (adSlotStyle) {
			if (Modernizr.positionfixed) {
				//position fixed needs to be applied after
				//a delay to avoid the Ad to jump in the
				//middle of the screen and then back to
				//the bottom on iOS 5+ (BugzId:38017)
				setTimeout(
					function () {
						adSlot.className += ' fixed';
					},
					1000
				);
			} else {
				adSlotStyle.top = Math.min(
					(w.pageYOffset + w.innerHeight - 50 + ~~plus),
					ftr.offsetTop + 150
				) + 'px';
			}
		}
	}

	function init() {
		adSlot = d.getElementById('wkAdPlc');

		if (adSlot) {
			adSlotStyle = adSlot.style;
			w = window;
			ftr = d.getElementById('wkFtr');

			var close = d.getElementById('wkAdCls'),
				i = 0,
				int,
				click = ev.click,
				adExist = function () {
					if (adSlot.childElementCount > 3) {
						close.className = 'show';
						adSlot.className += ' show';

						close.addEventListener(click, function () {
							//track('ad/close');
							adSlot.className += ' anim';
							setTimeout(function () {
								d.body.removeChild(adSlot);
							}, 800);
							w.removeEventListener('scroll', moveSlot);
						}, false);

						if (!Modernizr.positionfixed) {
							w.addEventListener('scroll', moveSlot);
						}
						return true;
					}

					return false;
				};

			if (!adExist()) {
				int = setInterval(function () {
					if (!adExist() && i < 5) {
						i += 1;
					} else {
						d.body.removeChild(adSlot);
						clearInterval(int);
					}
				}, 1000);
			}
		}
	}

	return {
		init: init,
		moveSlot: moveSlot
	};
});