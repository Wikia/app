/*global define*/
define('ext.wikia.paidAssetDrop.paidAssetDrop', [
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (instantGlobals, log, QueryString, win) {
	'use strict';

	var logGroup = 'ext.wikia.paidAssetDrop.paidAssetDrop',
		apiEntryPoint = '/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=json&titles=',
		qs = new QueryString(),
		validPageTypes = [
			'home',
			'article'
		],
		$ = win.$;

	log('Paid Asset Drop (PAD) loaded', 'debug', logGroup);

	function getAssetName(platform, pageType) {
		return 'MediaWiki:PAD_' + platform + '_' + pageType + '.html';
	}

	function isValidPageType(pageType) {
		return validPageTypes.indexOf(pageType) !== -1;
	}

	function isValidDate(dateString) {
		return !isNaN(Date.parse(dateString));
	}

	function isConfigValid(paidAssetDropConfig) {
		if (!paidAssetDropConfig) {
			log('paidAssetDropConfig is undefined', 'error', logGroup);
			return false;
		}

		if (!paidAssetDropConfig[0]) {
			log('No start date set', 'error', logGroup);
			return false;
		}

		if (!paidAssetDropConfig[1]) {
			log('No end date set', 'error', logGroup);
			return false;
		}

		if (!isValidDate(paidAssetDropConfig[0])) {
			log('Start date invalid', 'error', logGroup);
			return false;
		}

		if (!isValidDate(paidAssetDropConfig[1])) {
			log('End date invalid', 'error', logGroup);
			return false;
		}

		return true;
	}

	function isForced() {
		return qs.getVal('forcepad');
	}

	function isNowValid(paidAssetDropConfig) {
		var today, start, end;

		if (isForced()) {
			log('PAD enabled (forced)', 'debug', logGroup);
			return true;
		}

		if (instantGlobals.wgSitewideDisablePaidAssetDrop) {
			log('PAD disabled through instantGlobals.wgSitewideDisablePaidAssetDrop', 'debug', logGroup);
			return false;
		}

		if (!isConfigValid(paidAssetDropConfig)) {
			return false;
		}

		start = new Date(paidAssetDropConfig[0]);
		end = new Date(paidAssetDropConfig[1]);
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
		try {
			return response.query.pages[Object.keys(response.query.pages)[0]].revisions[0]['*'];
		} catch (e) {
			log(e, 'error', logGroup);
			return null;
		}
	}

	/**
	 * Inject the Paid Asset Drop
	 *
	 * @param {String} placeHolderSelector selector to drop the Paid Assets to (prepend)
	 * @param {String} platform            desktop or mobile
	 * @param {String} pageType            home or article
	 */
	function injectPad(placeHolderSelector, platform, pageType) {
		if (!isValidPageType(pageType)) {
			log('Invalid page type: ' + pageType, 'debug', logGroup);
			return;
		}

		var url = apiEntryPoint + getAssetName(platform, pageType);

		if (isForced()) {
			url += '&cb=' + Math.round(Math.random() * 1e6);
		} else {
			url += '&*'; // MediaWiki redirects us to this URL anyway
		}

		log('Sending request to: ' + url, 'debug', logGroup);

		$.ajax({url: url, dataType: 'json'}).then(function (response) {
			var padContent = fetchPadContent(response);

			if (padContent) {
				log('Injecting PAD into ' + placeHolderSelector, 'info', logGroup);
				$(placeHolderSelector).prepend(padContent);
			}
		});
	}

	return {
		isNowValid: isNowValid,
		injectPAD: injectPad
	};
});
