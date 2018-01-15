/*global define*/
define('ext.wikia.adEngine.ml.outstream.outstreamInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.browserDetect',
	'wikia.geo',
	'wikia.log',
	'wikia.window'
], function (pageParams, browserDetect, geo, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.outstream.outstreamInputParser',
		maxArticleHeight = 15000,
		maxViewportHeight = 3840;

	function getData() {
		var bodyHeight = win.document.body.scrollHeight,
			data,
			params = pageParams.getPageLevelParams(),
			viewportHeight = win.innerHeight;

		data = [
			parseInt(params.pv, 10) || 1,
			browserDetect.getBrowser().indexOf('Android') !== -1 ? 1: 0,
			params.s0 === 'ent' ? 1 : 0,
			params.ref === 'direct' ? 1 : 0,
			params.ref.indexOf('wiki') !== -1 ? 1 : 0,
			params.top === '1k' ? 1 : 0,
			bodyHeight ? Math.min(bodyHeight, maxArticleHeight) / maxArticleHeight : 0,
			viewportHeight ? Math.min(viewportHeight, maxViewportHeight) / maxViewportHeight : 0
		];

		log(['Outstream data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});
