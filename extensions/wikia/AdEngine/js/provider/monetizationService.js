define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.adContext',
	'wikia.loader',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window',
], function (adContext, loader, log, scriptWriter, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.monetizationService',
		slotMap = {
			MON_ABOVE_TITLE: 'above_title',
			MON_BELOW_TITLE: 'below_title',
			MON_IN_CONTENT: 'in_content',
			MON_BELOW_CATEGORY: 'below_category',
			MON_ABOVE_FOOTER: 'above_footer',
			MON_FOOTER: 'footer'
		},
		isLoaded = false;

	/**
	 * @desc loads all assets for monetization ads
	 */
	function loadAssets() {
		if (!isLoaded) {
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
			isLoaded = true;
		}
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);

		if (slotMap[slotName]) {
			log(['canHandleSlot', slotName, true], 'debug', logGroup);
			return true;
		}

		log(['canHandleSlot', slotName, false], 'debug', logGroup);
		return false;
	}

	function fillInSlot(slot, success) {
		log(['fillInSlot', slot], 'debug', logGroup);

		var slotName = slotMap[slot],
			context = adContext.getContext();

		if (context.providers.monetizationServiceAds && context.providers.monetizationServiceAds[slotName]) {
			log(['fillInSlot', slot, 'injectScript'], 'debug', logGroup);

			loadAssets();

			scriptWriter.injectHtml(slot, context.providers.monetizationServiceAds[slotName], function () {
				success();
			});
		}
	}

	return {
		name: 'MonetizationService',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
