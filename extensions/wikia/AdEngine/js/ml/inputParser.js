/*global define, require*/
define('ext.wikia.adEngine.ml.inputParser', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.utils.device',
	'wikia.geo',
	'wikia.log',
	'wikia.window'
], function (adContext, pageLevelParams, deviceDetect, geo, log, win) {
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
			videoId: featuredVideoData.mediaId || null,
			videoTag: featuredVideoData.videoTags || null,
			wikiId: win.wgCityId
		};

		log(['pageValues', pageValues], log.levels.debug, logGroup);
	}

	function getBinaryValue(property, value) {
		if (pageValues === null) {
			calculateValues();
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
