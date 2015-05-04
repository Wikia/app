define('ext.wikia.adEngine.monetizationsServiceHelper', [
	'jquery',
	'wikia.cache',
	'wikia.loader',
	'wikia.scriptwriter',
	'wikia.window',
], function ($, cache, loader, scriptWriter, window) {
	'use strict';

	var isEndOfContent = true;

	/**
	 * Loads all assets for monetization ads
	 */
	function loadAssets() {
		var assets,
			cacheKey = 'monetization_ads',
			scripts = 'monetization_module_js',
			styles = '/extensions/wikia/MonetizationModule/styles/MonetizationModule.scss',
			ttl = 604800;

		assets = cache.getVersioned(cacheKey);
		if (assets) {
			loader.processStyle(assets[0]);
			loader.processScript(assets[1]);
		} else {
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

				cache.setVersioned(cacheKey, [style, script], ttl);
			});
		}
	}

	function checkConditions(slotName) {
		if (slotName === 'below_category' && isEndOfContent) {
			return false;
		}

		return true;
	}

	function injectContent(slot, content, success) {
		scriptWriter.injectHtml(slot, content, function () {
			success();
		});
	}

	function addInContentSlot(slot, content, success) {
		var elementName = '#mw-content-text > h2',
			num = $(elementName).length,
			tag = '<div id="' + slot + '" class="wikia-ad noprint default-height"></div>';

		// TOC exists. Insert the ad above the 3rd <H2> tag.
		if ($('#toc').length > 0 && num > 3) {
			$(elementName).eq(2).before(tag);
			isEndOfContent = false;
		// TOC not exist. Insert the ad above the 2nd <H2> tag.
		} else if (num > 2) {
			$(elementName).eq(1).before(tag);
			isEndOfContent = false;
		// Otherwise, insert to the end of content
		} else {
			$('#mw-content-text').append(tag);
		}

		injectContent(slot, content, success);
	}

	return {
		addInContentSlot: addInContentSlot,
		checkConditions: checkConditions,
		injectContent: injectContent,
		loadAssets: loadAssets
	};
});
