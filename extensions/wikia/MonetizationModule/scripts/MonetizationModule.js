/**
 * JS file for Monetization Module.
 */

require(['wikia.tracker', 'wikia.geo'], function (Tracker, geo) {
	'use strict';

	var track;

	track = Tracker.buildTrackingFunction({
		trackingMethod: 'internal',
		action: Tracker.ACTIONS.CLICK,
		geo: geo.getCountryCode()
	});

	var MonetizationModule = {
		init: function () {
			// track impression for each placement
			$('.monetization-module').each(function () {
				var $this = $(this),
					trackCategory = $this.attr('id'),
					value = $this.children().children().length,	// check if the ad is blocked
					type = $this.attr('data-mon-type'),
					slot = $this.attr('data-mon-slot');

				track({
					category: trackCategory,
					label: 'module-impression',
					action: Tracker.ACTIONS.IMPRESSION,
					value: value,
					type: type,
					slot: slot
				});

				// track impression for each product
				if (type === 'ecommerce') {
					$this.find('.affiliate').each(function (idx, element) {
						var $element = $(element);
						track({
							category: $element.attr('data-mon-ptag'),
							label: 'product-impression',
							action: Tracker.ACTIONS.IMPRESSION,
							value: idx,
							type: type,
							slot: slot,
							pid: $element.attr('data-mon-pid')
						});
					});
				}
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
				'.module-title',
				'.product-thumb',
				'.product-name',
				'.product-price'
			];

			$('.monetization-module.ecommerce').on('click', elements.join(', '), function () {
				var $this = $(this),
					$module = $this.closest('.monetization-module'),
					$products = $module.find('.affiliate'),
					trackLabel = $this.attr('class').split(' ')[0],
					productUrl = $this.attr('href') || $this.find('a').attr('href'),
					$product;

				if (trackLabel === 'module-title') {
					$product = $products.first();
				} else {
					$product = $this.parent();
				}

				track({
					category: $module.attr('id'),
					label: trackLabel,
					value: $products.index($product),
					type: $module.attr('data-mon-type'),
					slot: $module.attr('data-mon-slot'),
					title: $product.attr('data-mon-pname'),
					pid: $product.attr('data-mon-pid'),
					ptag: $product.attr('data-mon-ptag'),
					url: productUrl
				});
			});
		}
	};

	MonetizationModule.init();
});
