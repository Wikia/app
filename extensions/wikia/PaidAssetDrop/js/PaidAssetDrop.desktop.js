define('ext.wikia.PaidAssetDrop', [
	'jquery',
	'wikia.log',
	'wikia.window'
], function ($, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.PaidAssetDrop',
		articleContentId = '#mw-content-text',
		assetArticleName = 'MediaWiki:PAD_desktop.html',
		apiEntryPoint = 'api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=json&titles=';

	log('Paid Asset Drop enabled', 'debug', logGroup);

	function isTodayValid() {
		//TODO: change me/finish me!
		return true;
	}

	function fetchPadContent(response) {
		var page, revision;

		if (response.query && response.query.pages && Object.keys) {
			page = response.query.pages[Object.keys(response.query.pages)[0]];

			log('Found page', 'debug', logGroup);
			log(page, 'debug', logGroup);

			if (page.revisions) {
				revision = page.revisions.pop();

				log('Found revision', 'debug', logGroup);
				log(revision, 'debug', logGroup);

				if (revision['*'] ) {
					return revision['*'];
				} else {
					log('Could not find revision[*]', 'debug', logGroup);
					return null;
				}
			} else {
				log('Could not find page revisions', 'debug', logGroup);
				return null;
			}
		}

		log('Could not find paid asset page', 'debug', logGroup);
		return null;
	}

	function injectPad() {
		var url = [win.wgServer, '/', apiEntryPoint, assetArticleName].join(''),
			padContent;

		log('Sending request to: ' + url, 'debug', logGroup);

		$.get(url).then(function (response) {
			padContent = fetchPadContent(response);

			if (padContent !== null) {
				$(articleContentId).prepend(padContent);
			}
		});
	}

	return {
		isTodayValid: isTodayValid,
		injectPAD: injectPad
	};
});

require([
	'ext.wikia.PaidAssetDrop',
	'wikia.window'
], function(pad, win) {
	'use strict';

	if (pad.isTodayValid() && win.wgEnableAPI) {
		pad.injectPAD();
	}
});
