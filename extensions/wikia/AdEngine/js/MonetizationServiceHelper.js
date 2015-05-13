define('ext.wikia.adEngine.monetizationsServiceHelper', [
	'jquery',
	'wikia.geo',
	'wikia.scriptwriter',
	'wikia.tracker',
	'wikia.window',
], function ($, geo, scriptWriter, tracker, window) {
	'use strict';

	var isEndOfContent = false,
		track = tracker.buildTrackingFunction({
			trackingMethod: 'internal',
			category: 'monetization-module',
			geo: geo.getCountryCode()
		});

	function validateSlot(slotName) {
		if (slotName === 'below_category' && isEndOfContent) {
			return false;
		}

		return true;
	}

	function injectContent(slot, content, success) {
		scriptWriter.injectHtml(slot, content, function () {
			var $container = $('#' + slot).find('.monetization-module');

			trackImpression($container);
			trackClickEvent($container);

			success();
		});
	}

	function addInContentSlot(slot) {
		var elementName = '#mw-content-text > h2',
			num = $(elementName).length,
			content = '<div id="' + slot + '" class="wikia-ad noprint default-height"></div>';

		// TOC exists. Insert the ad above the 3rd <H2> tag.
		if ($('#toc').length > 0 && num > 3) {
			$(elementName).eq(2).before(content);
		// TOC not exist. Insert the ad above the 2nd <H2> tag.
		} else if (num > 2) {
			$(elementName).eq(1).before(content);
		// Otherwise, insert to the end of content
		} else {
			$('#mw-content-text').append(content);
			isEndOfContent = true;
		}

		window.adslots2.push(slot);
	}

	function trackImpression($container) {
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
	}

	function trackClickEvent($container) {
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
				action: tracker.ACTIONS.CLICK + '-monetization-' + monType + '-' + slot + '-' + elementName,
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

	return {
		addInContentSlot: addInContentSlot,
		validateSlot: validateSlot,
		injectContent: injectContent
	};
});
