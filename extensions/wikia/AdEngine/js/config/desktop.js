/*global define*/
define('ext.wikia.adEngine.config.desktop', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.geo',
	'wikia.trackingOptIn',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adDecoratorPageDimensions',

	// adProviders
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.remnantGpt'
], function (
	// regular dependencies
	log,
	window,
	instantGlobals,
	geo,
	trackingOptIn,
	adContext,
	adDecoratorPageDimensions,

	// AdProviders
	adProviderDirectGpt,
	adProviderRemnantGpt
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		context = adContext.getContext(),
		gptEnabled = !instantGlobals.wgSitewideDisableGpt;

	function getDecorators() {
		return [adDecoratorPageDimensions];
	}

	function getProviderList(slotName) {
		var providerList = [],
			isTrackingOptedIn = trackingOptIn.isOptedIn();

		log('getProvider', 5, logGroup);
		log(slotName, 5, logGroup);
		log(['getProvider', 'tracking opted ' + (isTrackingOptedIn ? 'in' : 'out')], log.levels.info, logGroup);

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		if (gptEnabled) {
			providerList.push(adProviderDirectGpt);

			if (context.opts.premiumOnly) {
				return providerList;
			}
		}

		// Second provider: Remnant GPT
		if (gptEnabled) {
			providerList.push(adProviderRemnantGpt);
		}

		return providerList;
	}

	return {
		getDecorators: getDecorators,
		getProviderList: getProviderList
	};
});
