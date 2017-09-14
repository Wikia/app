/*global define, require*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.video.uapVideo',
	'wikia.log',
	require.optional('ext.wikia.adEngine.template.bfaaDesktop'),
	require.optional('ext.wikia.adEngine.template.bfaaMobile')
], function (
	adContext,
	uapContext,
	uapVideo,
	log,
	bfaaDesktop,
	bfaaMobile
) {
	'use strict';

	var bfaa,
		logGroup = 'ext.wikia.adEngine.template.bfaa';

	/**
	 * @param {object} params
	 * @param {float} params.aspectRatio - Ad container aspect ratio
	 * @param {string} params.backgroundColor - Hex value of background color
	 * @param {string} params.slotName - Slot name key-value needed for VastUrlBuilder
	 * @param {string} [params.adProduct] - Ad product type
	 * @param {string} [params.uap] - BFAA line item id
	 * @param {float} [params.videoAspectRatio] - Video aspect ratio
	 * @param {object} [params.videoTriggerElement] - DOM element which triggers video (button or background)
	 */
	function show(params) {
		var uapType = 'uap';

		if (uapVideo.isEnabled(params)) {
			uapType = 'vuap';
		}

		params.adProduct = params.adProduct || uapType;
		uapContext.setUapId(params.uap);
		uapContext.setType(params.adProduct);

		switch (adContext.getContext().targeting.skin) {
			case 'oasis':
				bfaa = bfaaDesktop;
				break;
			case 'mercury':
				bfaa = bfaaMobile;
				break;
			default:
				return log(['show', 'not supported skin'], log.levels.error, logGroup);
		}

		if (!bfaa) {
			log(['show', 'module is not loaded'], log.levels.error, logGroup);
		}

		bfaa.show(params);
	}

	return {
		show: show
	};
});
