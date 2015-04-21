define('ext.wikia.paidAssetDrop.paidAssetDrop', [
	'jquery',
	'wikia.log',
	'wikia.window'
], function ($, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.paidAssetDrop.paidAssetDrop',
		articleContentId = '#mw-content-text',
		assetArticleName = 'MediaWiki:PAD_desktop.html',
		apiEntryPoint = 'api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=json&titles=';

	log('Paid Asset Drop (PAD) loaded', 'debug', logGroup);

	function isValidDate(dateString) {
		return !isNaN(Date.parse(dateString));
	}

	function isConfigValid() {
		if (!win.wgPaidAssetDropConfig) {
			log('wgPaidAssetDropConfig is undefined', 'error', logGroup);
			return false;
		}

		if (!win.wgPaidAssetDropConfig[0]) {
			log('No start date set', 'error', logGroup);
			return false;
		}

		if (!win.wgPaidAssetDropConfig[1]) {
			log('No end date set', 'error', logGroup);
			return false;
		}

		if (!isValidDate(win.wgPaidAssetDropConfig[0])) {
			log('Start date invalid', 'error', logGroup);
			return false;
		}

		if (!isValidDate(win.wgPaidAssetDropConfig[1])) {
			log('End date invalid', 'error', logGroup);
			return false;
		}

		return true;
	}

	function isNowValid() {
		var today, start, end;

		if(!isConfigValid()) {
			return false;
		}

		start = new Date(win.wgPaidAssetDropConfig[0]);
		end = new Date(win.wgPaidAssetDropConfig[1]);
		today = new Date();

		log('PAD start date: ' + start, 'debug', logGroup);
		log('PAD end date: ' + end, 'debug', logGroup);
		log('PAD today is: ' + today, 'debug', logGroup);

		if (today.getTime() < start.getTime()) {
			log('PAD disabled: it is too early', 'debug', logGroup);
			return false;
		}

		if (today.getTime() > end.getTime()) {
			log('PAD disabled: it is too late', 'debug', logGroup);
			return false;
		}

		log('PAD enabled', 'debug', logGroup);
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
		isNowValid: isNowValid,
		injectPAD: injectPad
	};
});

require([
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.window'
], function(pad, win) {
	'use strict';

	if (pad.isNowValid() && win.wgEnableAPI) {
		pad.injectPAD();
	}
});
