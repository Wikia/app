define('ext.wikia.adEngine.monetizationsServiceHelper', [
	'jquery',
	'wikia.geo',
	'wikia.loader',
	'wikia.scriptwriter',
	'wikia.tracker',
	'wikia.window',
], function ($, geo, loader, scriptWriter, tracker, window) {
	'use strict';

	var isEndOfContent = false,
		track = tracker.buildTrackingFunction({
			trackingMethod: 'internal',
			category: 'monetization-module',
			geo: geo.getCountryCode()
		});

	/**
	 * @desc Loads all assets for monetization ads
	 */
	function loadAssets() {
		var scripts = 'monetization_module_js',
			styles = '/extensions/wikia/MonetizationModule/styles/MonetizationModule.scss';

		if (window.wgOasisBreakpoints) {
			styles = '/extensions/wikia/MonetizationModule/styles/MonetizationModuleNoBreakpoints.scss';
		}

		loader({
			type: loader.MULTI,
			resources: {
				styles: styles,
				scripts: scripts
			}
		}).done(function (res) {
			var script = res.scripts,
				style = res.styles;

			loader.processStyle(style);
			loader.processScript(script);
		});
	}

	/**
	 * @desc Validate slot
	 * @param {string} slotName
	 * @returns {boolean}
	 */
	function validateSlot(slotName) {
		if (slotName === 'below_category' && isEndOfContent) {
			return false;
		}

		return true;
	}

	/**
	 * @desc Inject content to the slot
	 * @param {string} slot
	 * @param {string} content
	 * @param {function} success
	 */
	function injectContent(slot, content, success) {
		scriptWriter.injectHtml(slot, content, function () {
			var $container = $('#' + slot).find('.monetization-module');

			trackImpression($container);
			trackClickEvent($container);

			success();
		});
	}

	/**
	 * @desc Add in-content slot
	 * @param {string} slot
	 */
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

	/**
	 * @desc Get maximum number of ads for the page
	 * @returns {number}
	 */
	function getMaxAds() {
		var pageHeight = $('#WikiaArticle').height();
		if (pageHeight > 5000) {
			return 3;
		} else if (pageHeight > 1500) {
			return 2;
		}
		return 1;
	}

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

	return {
		addInContentSlot: addInContentSlot,
		getMaxAds: getMaxAds,
		injectContent: injectContent,
		loadAssets: loadAssets,
		validateSlot: validateSlot
	};
});
