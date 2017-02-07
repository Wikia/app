/* global define */
define('ext.wikia.adEngine.slot.resolveState', [
	'wikia.log',
	'wikia.querystring'
], function (log, QueryString) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.resolveState',
		qs = new QueryString();

	function getQueryParam() {
		return qs.getVal('resolved_state', null);
	}

	function isForcedByURLParam() {
		return [true, 'true', '1'].indexOf(getQueryParam()) > -1;
	}

	function isBlockedByURLParam() {
		return [false, 'blocked', 'false', '0'].indexOf(getQueryParam()) > -1;
	}

	function paramsAreCorrect (params) {
		return params.resolveState.aspectRatio > 0 && params.resolveState.imageSrc !== '';
	}

	function hasResolvedState(params) {
		return isForcedByURLParam() || (paramsAreCorrect(params) && !isBlockedByURLParam());
	}

	function setResolveState(params) {
		log('Resolve state is turned on', logGroup, log.levels.debug);
		params.backgroundImage.src = params.resolveState.imageSrc;
		params.aspectRatio = params.resolveState.aspectRatio;
		return params;
	}

	function templateSupportsResolveState(params) {
		return params.backgroundImage;
	}

	function setDefaultState(params) {
		params.backgroundImage.src = params.imageSrc;
		return params;
	}

	function setImage(params) {
		if (templateSupportsResolveState(params)) {
			params = hasResolvedState(params) ? setResolveState(params) : setDefaultState(params);
		}

		return params;
	}

	return {
		setImage: setImage
	};
});
