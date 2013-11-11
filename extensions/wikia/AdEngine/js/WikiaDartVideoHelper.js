/*global define*/
define('ext.wikia.adengine.dartvideohelper', ['wikia.log', 'wikia.location', 'wikia.adlogicpageparams'], function (log, location, adLogicPageLevelParams) {
	'use strict';

	var logGroup = 'adengine.dartvideohelper',
		ord = Math.round(Math.random() * 23945290875),
		pageParams = adLogicPageLevelParams.getPageLevelParams();

	pageParams.src = 'ooyala';

	function getCustParams() {
		var key,  vals, params = [], urlEncodedVals, valIndex;

		for (key in pageParams) {
			if (pageParams.hasOwnProperty(key) && key !== '') {
				vals = pageParams[key];
				if (vals) {
					if (!(vals instanceof Array)) {
						vals = [vals];
					}
					urlEncodedVals = [];
					if (vals.length) {
						for (valIndex = 0; valIndex < vals.length; valIndex += 1) {
							// FIXME: why would it be empty ?
							if ( vals[valIndex] ) {
								urlEncodedVals.push(encodeURIComponent(vals[valIndex].toString()));
							} else {
								// log for Ad team
								urlEncodedVals.push('VID1030');
							}
						}
						params.push(key + '=' + urlEncodedVals.join(','));
					}
				}
			}
		}
		return params.join('&');
	}

	/**
	 * Get URL for Google IMAv3 call
	 *
	 * @return {String} URL of DART script
	 */
	function getUrl() {
		log('getUrl', 5, logGroup);
		var out = 'http://pubads.g.doubleclick.net/gampad/ads?' +
			'env=vp&gdfp_req=1&impl=s&output=xml_vast2&' +
			'iu=/5441/wka.' + pageParams.s0 + '//' + pageParams.s1 + '//' + pageParams.s2 + '&' +
			'sz=320x240&' +
			'unviewed_position_start=1&' +
			'url=' + encodeURIComponent(location.href) + '&' +
			'cust_params=' + encodeURIComponent(getCustParams()) + '&' +
			'correlator=' + ord;

		log(out, 5, logGroup);
		return out;
	}

	return {
		getUrl: getUrl
	};
});
