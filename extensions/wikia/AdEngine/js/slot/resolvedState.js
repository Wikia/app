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
		var correctSingleImage = params.resolvedState && params.resolvedState.imageSrc,
			correctMultipleImages = params.image1 && params.image2 &&
				params.image1.resolvedStateSrc !== '' && params.image2.resolvedStateSrc !== '';

		return correctSingleImage !== '' || correctMultipleImages;
	}

	function hasResolvedState(params) {
		return isForcedByURLParam() || (paramsAreCorrect(params) && !isBlockedByURLParam());
	}

	function setResolvedState(params) {
		log('Resolved state is turned on', logGroup, log.levels.debug);
		params.aspectRatio = params.resolvedStateAspectRatio || params.resolvedState.aspectRatio;
		if (params.backgroundImage) {
			params.backgroundImage.src = params.resolvedState.imageSrc;
		} else {
			params.image1.element.src = params.image1.resolvedStateSrc;
			params.image2.element.src = params.image2.resolvedStateSrc;
		}

		return params;
	}

	function templateSupportsResolvedState(params) {
		var correctMultipleImages = params.image1 && params.image2;

		return params.backgroundImage || correctMultipleImages;
	}

	function setDefaultState(params) {
		if (params.backgroundImage) {
			params.backgroundImage.src = params.imageSrc;
		} else {
			params.image1.element.src = params.image1.defaultStateSrc;
			params.image2.element.src = params.image2.defaultStateSrc;
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
