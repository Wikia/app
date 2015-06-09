/**
 * JS file for Monetization Module.
 */

require(['wikia.tracker', 'wikia.geo'], function (Tracker, geo) {
	'use strict';

	var track;

	track = Tracker.buildTrackingFunction({
		trackingMethod: 'internal',
		category: 'monetization-module',
		geo: geo.getCountryCode()
	});

	var MonetizationModule = {
		init: function () {
			var $container = $('.monetization-module');

			this.trackImpression($container);
			this.trackClickEvent($container);
		},
		trackImpression: function ($container) {
			// track impression for each placement
			$container.each(function () {
				var $this = $(this),
					value = $this.children().children().length,	// check if the ad is blocked
					monType = $this.attr('data-mon-type'),
					slot = $this.attr('data-mon-slot'),
					label = 'monetization-' + monType + '-' + slot;

				track({
					action: 'module-impression',
					label: label,
					value: value,
					type: monType,
					slot: slot
				});

				// track impression for each product
				if (monType === 'ecommerce' || monType === 'amazon_video') {
					$this.find('.affiliate').each(function (idx, element) {
						var $element = $(element);
						track({
							label: $element.attr('data-mon-ptag'),
							action: 'product-impression-' + label,
							value: idx,
							type: monType,
							slot: slot,
							pid: $element.attr('data-mon-pid')
						});
					});
				}
			});
		},
		trackClickEvent: function ($container) {
			var elements = [
				'.module-title',
				'.product-thumb',
				'.product-name',
				'.product-price',
				'.amazon-logo',
				'.product-btn'
			];

			$container.on('click', elements.join(', '), function () {
				var $this = $(this),
					$module = $this.closest('.monetization-module'),
					$products = $module.find('.affiliate'),
					monType = $module.attr('data-mon-type'),
					slot = $module.attr('data-mon-slot'),
					elementName = $this.attr('class'),
					productUrl = $this.attr('href') || $this.find('a').attr('href'),
					$product = $products.first();

				if (monType !== 'amazon_video' && elementName !== 'module-title') {
					$product = $this.parent();
				}

				track({
					action: Tracker.ACTIONS.CLICK + '-monetization-' + monType + '-' + slot + '-' + elementName,
					label: $product.attr('data-mon-ptag'),
					value: $products.index($product),
					type: monType,
					slot: slot,
					title: $product.attr('data-mon-pname'),
					pid: $product.attr('data-mon-pid'),
					element: elementName,
					url: productUrl
				});
			});
		}
	};

	MonetizationModule.init();
});
