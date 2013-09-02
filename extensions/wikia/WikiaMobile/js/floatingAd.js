window.addEventListener('load', function(){
	'use strict';

	if(!Wikia.AbTest || ['E', undefined].indexOf(Wikia.AbTest.getGroup('WIKIAMOBILEADSLOTS')) !== -1){
		require(['ads', 'wikia.window', 'jquery'], function (ads, window, $) {
			var wrapper = document.getElementById('wkFloatingAd'),
				positionfixed = window.Features.positionfixed,
				fixed,
				found,
				ftr = window.document.getElementById('wkFtr') || window.document.body,
				classes = 'over fixed',
				$wrapper = $(wrapper),
				$ftr = $(ftr);

			if(!positionfixed) {
				classes += ' jsfix';
			}

			/**
			 * Moves the slot at the bottom of the viewport
			 * used when Modernizr.positionfixed is false
			 * and we need to take care of emulating it in JS
			 * (iOS < 5 and Android < 3)
			 *
			 * @param {mixed} plus An offset to consider when calculating the position
			 *
			 * @private
			 */
			function moveSlot(plus) {
				wrapper.style.top = Math.min(
					(window.pageYOffset + window.innerHeight - 50 + ~~plus),
					ftr.offsetTop + 160
				) + 'px';
			}

			/**
			 * Handles the positioning of the Ad either via CSS or JS
			 * to make it "float" on the viewport, the position and
			 * behaviour depends on the type of Ad
			 *
			 * @public
			 */
			function fix() {
				if (found) {
					fixed = true;

					//give the footer space to host the
					//"floating" footer Ad
					if (!positionfixed) {
						window.addEventListener('scroll', moveSlot);
						moveSlot();
					}

					$wrapper.addClass(classes);
					//$.addClass(wrapper, classes);
					$ftr.addClass('ads');
					//$.addClass(ftr || window.document.body, ['ads']);
				}
			}

			/**
			 * Handles the positioning of the Ad either via CSS or JS
			 * to anchor it back in the original position before
			 * fix was called, the position and
			 * behaviour depends on the type of Ad
			 *
			 * @public
			 */
			function unfix() {
				if (found) {
					//reset fixed after moveSlot has been called
					fixed = false;

					if (!positionfixed) {
						window.removeEventListener('scroll', moveSlot);
						moveSlot(ftr.offsetTop);
					}

					//$.removeClass(wrapper, classes);
					//$.removeClass(ftr || window.document.body, ['ads']);
					$wrapper.removeClass(classes);
					$ftr.removeClass('ads');
				}
			}

			if (wrapper) {
				ads.setupSlot({
					name: 'MOBILE_FLOATING_FOOTER',
					size: '320x50',
					wrapper: wrapper,
					init: function(){
						found = true;

					fix();

					$(document)
						.on('ads:fix', fix)
						.on('ads:unfix', unfix);
					}
				});
			}
		});
	}
});
