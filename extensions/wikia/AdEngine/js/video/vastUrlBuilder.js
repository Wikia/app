/*global define*/
define('ext.wikia.adEngine.video.vastUrlBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slot.slotTargeting',
	'wikia.location',
	'wikia.log'
], function (adContext, page, regularAdUnitBuilder, megaAdUnitBuilder, slotTargeting, loc, log) {
	'use strict';
	var adSizes = {
			vertical: '320x480',
			horizontal: '640x480'
		},
		availableVideoPositions = ['preroll', 'midroll', 'postroll'],
		baseUrl = 'https://pubads.g.doubleclick.net/gampad/ads?',
		logGroup = 'ext.wikia.adEngine.video.vastUrlBuilder';

	function getCustomParameters(slotParams) {
		var customParameters,
			params = page.getPageLevelParams(),
			wsi = slotTargeting.getWikiaSlotId(slotParams.pos, slotParams.src);

		customParameters = ['wsi=' + wsi];

		Object.keys(params).forEach(function (key) {
			if (params[key]) {
				customParameters.push(key + '=' + params[key]);
			}
		});

		Object.keys(slotParams).forEach(function (key) {
			if (slotParams[key]) {
				customParameters.push(key + '=' + slotParams[key]);
			}
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function getSizeByAspectRatio(aspectRatio) {
		return aspectRatio >= 1 || !isNumeric(aspectRatio) ? adSizes.horizontal : adSizes.vertical;
	}

	function buildAdUnit(slotParams, useMegaAdUnitBuilder) {
		var adUnitBuilder = useMegaAdUnitBuilder ? megaAdUnitBuilder : regularAdUnitBuilder;
		return adUnitBuilder.build(slotParams.pos, slotParams.src);
	}

	/**
	 * Creates VAST URL from given parameters.
	 * If `options.useMegaAdUnitBuilder` is not explicitly provided, the `context.opts.megaAdUnitBuilderEnabled` is used.
	 * @param {number} aspectRatio
	 * @param {object} slotParams
	 * @param {object} options
	 * @returns {string}
	 */
	function build(aspectRatio, slotParams, options) {
		options = options || {};
		slotParams = slotParams || {};

		var correlator = options.correlator || Math.round(Math.random() * 10000000000),
			useMegaAdUnitBuilder = options.useMegaAdUnitBuilder,
			params,
			url;

		if (typeof useMegaAdUnitBuilder === 'undefined') {
			useMegaAdUnitBuilder = adContext.getContext().opts.megaAdUnitBuilderEnabled;
			log(['build', '`useMegaAdUnitBuilder` option is not defined. Fallback to `context.opts.megaAdUnitBuilderEnabled`.'], 'debug', logGroup);
		}

		params = [
			'output=vast',
			'env=vp',
			'gdfp_req=1',
			'impl=s',
			'unviewed_position_start=1',
			'iu=' + (options.adUnit || buildAdUnit(slotParams, useMegaAdUnitBuilder)),
			'sz=' + getSizeByAspectRatio(aspectRatio),
			'url=' + encodeURIComponent(loc.href),
			'description_url=' + encodeURIComponent(loc.href),
			'correlator=' + correlator,
			'cust_params=' + getCustomParameters(slotParams)
		];

		if (typeof options.numberOfAds !== 'undefined') {
			params.push('pmad=' + options.numberOfAds);
		}

		if (options.vpos && availableVideoPositions.indexOf(options.vpos) > -1) {
			params.push('vpos=' + options.vpos);
		}

		if (options.contentSourceId && options.videoId) {
			params.push('cmsid=' + options.contentSourceId);
			params.push('vid=' + options.videoId);
		}

		url = baseUrl + params.join('&');
		log(['build', url], 'debug', logGroup);

		return url;
	}

	return {
		build: build
	};
});
