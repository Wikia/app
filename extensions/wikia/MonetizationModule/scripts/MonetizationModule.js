/**
 * JS file for Monetization Module.
 */

require(['wikia.tracker'], function (Tracker) {
	'use strict';

	var track;

	track = Tracker.buildTrackingFunction({
		category: 'monetization-module',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.CLICK
	});

	var MonetizationModule = {
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
				.on('resize.monetizationmodule', function () {
					$('.monetization-module').find('.placard a').ellipses({
						maxLines: 3
					});
				})
				.trigger('resize.monetizationmodule');
		},
		initClickTracking: function() {
			var elements = [
				'.prod-thumb',
				'.prod-name',
				'.vendor-logo',
				'.vendor-button',
				'.vendor-price'
			];

			$('.monetization-module').on('click', elements.join(', '), function () {
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
				trackCategory = $(this).closest('.monetization-module').attr('id');
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

	MonetizationModule.init();
});
