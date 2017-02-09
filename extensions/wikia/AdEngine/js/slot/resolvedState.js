/*global define*/
define('ext.wikia.adEngine.slot.resolvedState', [
	'wikia.log',
	'wikia.querystring'
], function (log, QueryString) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.resolvedState',
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
		var correctSplitImages = params.resolvedState.leftImageSrc && params.resolvedState.rightImageSrc;

		return params.resolvedState.imageSrc !== '' || correctSplitImages;
	}

	function hasResolvedState(params) {
		return isForcedByURLParam() || (paramsAreCorrect(params) && !isBlockedByURLParam());
	}

	function setResolvedState(params) {
		log('Resolved state is turned on', logGroup, log.levels.debug);
		params.aspectRatio = params.resolvedState.aspectRatio;
		if (params.backgroundImage) {
			params.backgroundImage.src = params.resolvedState.imageSrc;
		} else {
			params.backgroundLeftImage.src = params.resolvedState.leftImageSrc;
			params.backgroundRightImage.src = params.resolvedState.rightImageSrc;
		}

		return params;
	}

	function templateSupportsResolvedState(params) {
		return params.backgroundImage || (params.backgroundLeftImage && params.backgroundRightImage);
	}

	function setDefaultState(params) {
		if (params.backgroundImage) {
			params.backgroundImage.src = params.imageSrc;
		} else {
			params.backgroundLeftImage.src = params.leftImageSrc;
			params.backgroundRightImage.src = params.rightImageSrc;
		}

		return params;
	}

	function setImage(params) {
		if (templateSupportsResolvedState(params)) {
			params = hasResolvedState(params) ? setResolvedState(params) : setDefaultState(params);
		}

		return params;
	}

	return {
		setImage: setImage
	};
});
