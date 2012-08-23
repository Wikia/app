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
		ftr,
		fixed = false,
		positionfixed = Modernizr.positionfixed;

	//init
	$(function(){
		adSlot = d.getElementById('wkAdPlc');

		if (adSlot) {
			adSlotStyle = adSlot.style;
			w = window;
			ftr = d.getElementById('wkFtr');

			var close = d.getElementById('wkAdCls'),
				i = 0,
				adInt,
				click = ev.click,
				adExist = function () {
					if (adSlot.childElementCount > 3) {
						close.className = 'show';
						adSlot.className += ' show';

						fix();

						close.addEventListener(click, function () {
							//track('ad/close');
							adSlot.className += ' anim';
							setTimeout(function () {
								d.body.removeChild(adSlot);
							}, 800);
							!positionfixed && w.removeEventListener('scroll', moveSlot);
						}, false);

						!positionfixed && w.addEventListener('scroll', moveSlot);

						return true;
					}

					return false;
				};

			if (!adExist()) {
				adInt = setInterval(function () {
					if (!adExist() && i < 5) {
						i += 1;
					} else {
						d.body.removeChild(adSlot);
						clearInterval(adInt);
					}
				}, 1000);
			}
		}
	});

	//private
	function moveSlot(plus) {
		if(fixed) {
			adSlotStyle.top = Math.min(
				(w.pageYOffset + w.innerHeight - 50 + ~~plus),
				ftr.offsetTop + 160
			) + 'px';
		}
	}

	//public
	function fix(){
		if(adSlot){
			if(positionfixed){
				//position fixed needs to be applied after
				//a delay to avoid the Ad to jump in the
				//middle of the screen and then back to
				//the bottom on iOS 5+ (BugzId:38017)
				setTimeout(
					function(){
						adSlot.className += ' fixed over';
					},
					100
				);
			} else{
				adSlot.className += ' over';
				moveSlot();
			}
			fixed = true;
		}
	}

	//public
	function unfix(){
		if(adSlot){
			if(positionfixed){
				adSlot.className = adSlot.className.replace(' fixed over', '');
			} else {
				adSlot.className = adSlot.className.replace(' over', '');
				moveSlot(wkFtr.offsetTop);
			}
			fixed = false;
		}
	}

	return {
		fix: fix,
		unfix: unfix
	};
});