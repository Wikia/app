<aside class=wkAdPlace>
<div id=wkAdFloatingTopLeader></div>
<script>window.addEventListener('load', function () {
	require(['ads'], function (ads) {
		var wrapper = document.getElementById('wkAdFloatingTopLeader');

		/**
		 * Handles the positioning of the Ad either via CSS or JS
		 * to make it "float" on the viewport, the position and
		 * behaviour depends on the type of Ad
		 *
		 * @public
		 */
		function fix() {
			fixed = true;

			if (found) {
				$.addClass(adSlot, ['over']);

				if (type === AD_TYPES.footer) {
					//give the footer space to host the
					//"floating" footer Ad
					$.addClass(ftr, ['ads']);
					$.addClass(adSlot, ['fixed']);

					if (!positionfixed) {
						$.addClass(adSlot, ['jsfix']);
						moveSlot();
					}
				}
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
				var positionfixed = window.Features.positionfixed,
					ftr,
					inited,
					adSlotStyle = adSlot.style,
					ftr = d.getElementById('wkFtr');
			}
		});
	});
});</script>
</aside>
