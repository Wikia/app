/* global define */
define('ext.wikia.adEngine.slot.resolveState', [
	'wikia.log',
	'wikia.querystring'
], function (log, QueryString) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.resolveState',
		qs = new QueryString();

	function replaceImage(params) {
		params.backgroundImage.src = params.resolveState.imageSrc;
	}

	function getQueryParam() {
		return qs.getVal('resolvedState', null);
	}

	function isForcedByURLParam() {
		return [true, 'true'].indexOf(getQueryParam()) > -1;
	}

	function isBlockedByURLParam() {
		return [false, 'blocked', 'false'].indexOf(getQueryParam()) > -1;
	}

	function paramsAreCorrect (params) {
		return params.resolveState.aspectRatio > 0 && params.resolveState.imageSrc !== '';
	}

	function hasResolvedState(params) {
		return isForcedByURLParam() || (paramsAreCorrect(params) && !isBlockedByURLParam());
	}

	function updateAd(params) {
		log('Resolve state is turned on', logGroup, log.levels.debug);
		replaceImage(params);
		params.aspectRatio = params.resolveState.aspectRatio;
		return params;
	}

	return {
		hasResolvedState: hasResolvedState,
		updateAd: updateAd
	};
});
