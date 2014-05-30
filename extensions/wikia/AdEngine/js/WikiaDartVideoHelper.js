/*global define*/
define('ext.wikia.adEngine.dartVideoHelper', ['wikia.log', 'wikia.location', 'ext.wikia.adEngine.adLogicPageParams'], function (log, location, adLogicPageParams) {
	'use strict';

	var logGroup = 'adengine.dartVideoHelper',
		pageParams = adLogicPageParams.getPageLevelParams();

	pageParams.src = 'ooyala';

	function getCustParams() {
		var key,  vals, params = [], urlValues, valIndex;

		for (key in pageParams) {
			if (pageParams.hasOwnProperty(key) && key !== '') {
				vals = pageParams[key];
				if (vals && vals.length) {
					if (!(vals instanceof Array)) {
						vals = [vals];
					}
					urlValues = [];

					for (valIndex = 0; valIndex < vals.length; valIndex += 1) {
						urlValues.push(vals[valIndex].toString());
					}

					params.push(key + '=' + urlValues.join(','));
				}
			}
		}
		return params.join('&');
	}

	/**
	 * Get URL for VAST call
	 *
	 * @return {String} URL of DART script
	 */
	function getUrl() {
		log('getUrl', 5, logGroup);

		var ord = Math.round(Math.random() * 23945290875),
			out = [
			'http://pubads.g.doubleclick.net/gampad/ads?ciu_szs',
			'&iu=/5441/wka.ooyalavideo/_page_targeting',
			'&cust_params=' + encodeURIComponent(getCustParams()),
			'&sz=320x240',
			'&impl=s',
			'&output=xml_vast2',
			'&gdfp_req=1',
			'&env=vp',
			'&ad_rule=0',
			'&unviewed_position_start=1',
			'&url=' + location.origin,
			'&correlator=' + ord
		].join('');

		log(out, 5, logGroup);

		return out;
	}

	return {
		getUrl: getUrl
	};
});
