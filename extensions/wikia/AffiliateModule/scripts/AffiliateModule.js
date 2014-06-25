/**
 * JS file for Affiliate Module.
 */

require(['wikia.tracker'], function (Tracker) {
	'use strict';

	var track;

	track = Tracker.buildTrackingFunction({
		category: 'affiliate-module',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.CLICK
	});

	var AffiliateModule = {
		init: function () {
			// track impression
			track({
				trackingMethod: 'both',
				label: 'module-impression',
				action: Tracker.ACTIONS.IMPRESSION
			});

			this.initEllipses();
			this.initClickTracking();
		},
		initEllipses: function() {
			$(window)
				.on('resize.affiliatemodule', function () {
					$('.affiliate-module').find('.placard a').ellipses({
						maxLines: 3
					});
				})
				.trigger('resize.affiliatemodule');
		},
		initClickTracking: function() {
			var elements = [
				'.prod-thumb',
				'.prod-name',
				'.vendor-logo',
				'.vendor-button',
				'.vendor-price'
			];

			$('.affiliate-module').on('click', elements.join(', '), function () {
				var $products,
					$product,
					trackCategory,
					trackLabel,
					trackValue,
					vendor,
					productName,
					productId,
					productUrl;

				$products = $(this).closest('.affiliate');
				$product = $products.find('.prod-thumb img');
				trackCategory = $(this).closest('.affiliate-module').attr('id');
				trackLabel = $(this).attr('class').split(' ')[0];
				trackValue = $products.index();
				vendor = $products.find('.vendor').attr('class').split(' ')[0];
				productName = $product.attr('data-prod-name');
				productId = $product.attr('data-prod-id');
				productUrl = $(this).attr('href');

				track({
					category: trackCategory,
					label: trackLabel,
					value: trackValue,
					title: productName,
					pid: productId,
					vendor: vendor,
					url: productUrl
				});
			});
		}
	};

	AffiliateModule.init();
});
