/* global define */
define('ext.wikia.wikiFactory.requestManager', ['mw'], function (mw) {
	'use strict';

	return {
		doApiRequest: function(formData, callback) {
			var xmlHttpRequest = new XMLHttpRequest();
			xmlHttpRequest.responseType = 'json';

			xmlHttpRequest.onreadystatechange = callback;

			xmlHttpRequest.open('POST', mw.util.wikiScript('api'));
			xmlHttpRequest.send(formData);
		}
	};
});
