/*global define*/
define('ext.wikia.adEngine.provider.monetizationService.helper', [
	'jquery',
	'wikia.geo',
	'wikia.scriptwriter',
	'wikia.tracker'
], function ($, geo, scriptWriter, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
			trackingMethod: 'internal',
			category: 'monetization-module',
			geo: geo.getCountryCode()
		});

	/**
	 * @desc Track impression
	 */
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

	/**
	 * @desc Track click event
	 */
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

	/**
	 * @desc Inject content to the slot
	 * @param {HTMLElement} slotElement
	 * @param {string} content
	 * @param {function} success
	 */
	function injectContent(slotElement, content, success) {
		scriptWriter.injectHtml(slotElement, content, function () {
			var $container = $(slotElement).find('.monetization-module');

			trackImpression($container);
			trackClickEvent($container);

			success();
		});
	}

	/**
	 * @desc Get maximum number of ads for the page
	 * @returns {number}
	 */
	function getMaxAds() {
		var pageHeight = $('#WikiaArticle').height();

		if (pageHeight > 5000) {
			return 3;
		}

		if (pageHeight > 1500) {
			return 2;
		}

		return 1;
	}

	/**
	 * @desc Get country code
	 * @returns {string}
	 */
	function getCountryCode() {
		var countryCodeROW = 'ROW',
			countryCodes = ['AU', 'CA', 'DE', 'GB', 'HK', 'JP', 'MX', 'RU', 'TW', 'US'],
			countryCode = geo.getCountryCode();
		if ($.inArray(countryCode, countryCodes) >= 0) {
			return countryCode;
		}
		return countryCodeROW;
	}

	return {
		getCountryCode: getCountryCode,
		getMaxAds: getMaxAds,
		injectContent: injectContent
	};
});
