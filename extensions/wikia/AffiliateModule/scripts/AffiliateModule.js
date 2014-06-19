/**
 * JS file for Affiliate Module. Runs on Monobook and Oasis.
 */

$(function () {
	'use strict';

	var AffiliateModule = {
		init: function () {
			this.initEllipses();
		},
		initEllipses: function() {
			$(window)
				.on('resize.affiliatemodule', function () {
					$('.affiliate-module').find('.placard a').ellipses({
						maxLines: 3
					});
				})
				.trigger('resize.affiliatemodule');
		}
	};

	AffiliateModule.init();
});
