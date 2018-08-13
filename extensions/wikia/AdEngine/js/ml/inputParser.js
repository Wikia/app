/*global define*/
define('ext.wikia.adEngine.ml.inputParser', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.utils.device',
	'ext.wikia.adEngine.geo',
	'wikia.log'
], function (adContext, pageLevelParams, deviceDetect, geo, log) {
	'use strict';

	var pageValues = null,
		logGroup = 'ext.wikia.adEngine.ml.inputParser';

	function calculateValues() {
		var featuredVideoData = adContext.get('targeting.featuredVideo') || {},
			pageParams = pageLevelParams.getPageLevelParams();

		pageValues = {
			country: geo.getCountryCode() || null,
			device: deviceDetect.getDevice(pageParams),
			esrb: pageParams.esrb || null,
			isTopWiki: !!adContext.get('targeting.wikiIsTop1000'),
			namespace: pageParams.s2 || null,
			trafficSource: pageParams.ref || null,
			verticalName: pageParams.s0v || null,
			videoId: featuredVideoData.mediaId || null,
			videoTag: featuredVideoData.videoTags || null,
			wikiId: adContext.get('targeting.wikiId') || null
		};

		log(['pageValues', pageValues], log.levels.debug, logGroup);
	}

	function getBinaryValue(property, value) {
		if (pageValues === null) {
			calculateValues();
		}

		if (typeof pageValues[property] === 'undefined') {
			throw new Error('Value for "' + property + '" is not defined.');
		}

		if (Array.isArray(pageValues[property])) {
			return pageValues[property].indexOf(value) !== -1 ? 1 : 0;
		}

		return pageValues[property] === value ? 1 : 0;
	}

	function parse(modelPropertiesAndValues) {
		var data = [];

		modelPropertiesAndValues.forEach((function (row) {
			data.push(getBinaryValue(row.name, row.value));
		}));

		return data;
	}

	adContext.addCallback(function () {
		pageValues = null;
	});

	return {
		parse: parse
	};
});
