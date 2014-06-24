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
					trackCategory,
					trackLabel,
					trackValue,
					productName,
					productUrl;

				$products = $(this).closest('.affiliate');
				trackCategory = $(this).closest('.affiliate-module').attr('id');
				trackValue = $products.index();
				productUrl = $(this).attr('href');

				if ($(this).hasClass('vendor-button')) {
					trackLabel = 'vendor-button';
				} else {
					trackLabel = $(this).attr('class');
				}

				if (trackLabel === 'prod-name') {
					productName = $(this).attr('title');
				} else {
					productName = $products.find('.prod-name').attr('title');
				}

				track({
					category: trackCategory,
					label: trackLabel,
					value: trackValue,
					title: productName,
					url: productUrl
				});
			});
		}
	};

	AffiliateModule.init();
});
