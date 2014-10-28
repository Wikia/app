/**
 * JS file for Monetization Module.
 */

require(['wikia.tracker', 'wikia.geo'], function (Tracker, geo) {
	'use strict';

	var track;

	track = Tracker.buildTrackingFunction({
		trackingMethod: 'internal',
		action: Tracker.ACTIONS.CLICK
	});

	var MonetizationModule = {
		init: function () {
			// track impression for each placement
			$('.monetization-module').each(function () {
				var $this = $(this),
					trackCategory = $this.attr('id'),
					value = $this.children().children().length,	// check if the ad is blocked
					type = $this.attr('data-mon-type');

				track({
					category: trackCategory,
					label: 'module-impression',
					action: Tracker.ACTIONS.IMPRESSION,
					value: value,
					geo: geo.getCountryCode(),
					type: type
				});
			});

			this.initEllipses();
			this.initClickTrackingEcommerce();
		},
		initEllipses: function () {
			$(window)
				.on('resize.monetizationmodule', function () {
					$('.monetization-module').find('.placard a').ellipses({
						maxLines: 3
					});
				})
				.trigger('resize.monetizationmodule');
		},
		initClickTrackingEcommerce: function () {
			var elements = [
				'.prod-thumb',
				'.prod-name',
				'.vendor-logo',
				'.vendor-button',
				'.vendor-price'
			];

			$('.monetization-module.ecommerce').on('click', elements.join(', '), function () {
				var $products,
					$productThumb,
					$module,
					trackCategory,
					trackLabel,
					trackValue,
					type,
					vendor,
					productName,
					productId,
					productUrl;

				$products = $(this).closest('.affiliate');
				$productThumb = $products.find('.prod-thumb img');
				$module = $(this).closest('.monetization-module');
				trackCategory = $module.attr('id');
				trackLabel = $(this).attr('class').split(' ')[0];
				trackValue = $products.index();
				vendor = $products.find('.vendor').attr('class').split(' ')[0];
				type = $module.attr('class').split(' ')[1];
				productName = $productThumb.attr('data-prod-name');
				productId = $productThumb.attr('data-prod-id');
				productUrl = $(this).attr('href');

				track({
					category: trackCategory,
					label: trackLabel,
					value: trackValue,
					title: productName,
					pid: productId,
					vendor: vendor,
					type: type,
					url: productUrl
				});
			});
		}
	};

	MonetizationModule.init();
});
