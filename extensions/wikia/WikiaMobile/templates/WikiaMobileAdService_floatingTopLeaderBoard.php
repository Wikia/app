<aside class=wkAdPlace>
<div id=wkAdFloatingTopLeader></div>
<script>window.addEventListener('load', function () {
	require(['ads', 'wikia.window'], function (ads, window) {
		var wrapper = document.getElementById('wkAdFloatingTopLeader'),
			adSlot = wrapper.parentElement,
			adSlotStyle = adSlot.style,
			positionfixed = window.Features.positionfixed,
			fixed,
			inited,
			ftr,
			d = window.document;

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
			if (fixed) {
				wrapper.style.top = Math.min(
					(window.pageYOffset + window.innerHeight - 50 + ~~plus),
					ftr.offsetTop + 160
				) + 'px';
			}
		}

		/**
		 * Handles the positioning of the Ad either via CSS or JS
		 * to make it "float" on the viewport, the position and
		 * behaviour depends on the type of Ad
		 *
		 * @public
		 */
		function fix() {
			fixed = true;

//			if (found) {
				var classes = ['footer', 'over', 'fixed'];

				//give the footer space to host the
				//"floating" footer Ad
				if (!positionfixed) {
					classes.push('jsfix');
					moveSlot();
				}

				$.addClass(wrapper, classes);
				$.addClass(ftr, ['ads']);
//			}
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
				$.removeClass(adSlot, ['over']);

				if (type === AD_TYPES.footer) {
					//remove the extra space from the footer used
					//to host the "floating" footer Ad
					$.removeClass(ftr, ['ads']);
					$.removeClass(adSlot, ['fixed']);

					if (!positionfixed) {
						$.removeClass(adSlot, ['jsfix']);
						moveSlot(ftr.offsetTop);
					}
				}
			}

			//reset fixed after moveSlot has been called
			fixed = false;
		}

		ads.setupSlot({
			name: 'MOBILE_TOP_LEADERBOARD',
			size: '320x50',
			wrapper: wrapper,
			init: function(){
				ftr = d.getElementById('wkFtr');

				//just do the necessary setup
				//binding findAd to domwriter's
				//idle event will do the rest,
				//no more need for timers & co :)
//				if (adSlot && AD_TYPES.hasOwnProperty(adType)) {
					//if the slot was already initialized once
					//then do some cleanup
//					if (inited) {
//						for (var t in AD_TYPES) {
//							if (AD_TYPES.hasOwnProperty(t)) {
//								$.removeClass(adSlot, ['footer']);
//							}
//						}
//					}

					//used in other parts to check what kind of Ad we've been served
					inited = true;
					//$.addClass(adSlot, []);

				if (!positionfixed) {
					window.addEventListener('scroll', moveSlot);
				}

				fix();

				//process any option passed in
//				if (options) {
//					//option to stop showing ads for X seconds
//					if (typeof options.stop === 'number') {
//						stop(options.stop);
//					}
//				}
//				}
			}
		});
	});
});</script>
</aside>
