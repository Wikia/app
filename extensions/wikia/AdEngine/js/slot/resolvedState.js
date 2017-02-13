/*global define*/
define('ext.wikia.adEngine.slot.resolvedState', [
	'ext.wikia.adEngine.context.uapContext',
	'wikia.cache',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (uapContext, cache, log, QueryString, win) {
	'use strict';

	var cacheKey = 'adEngine_resolvedStateCounter',
		cacheTtl = cache.CACHE_STANDARD, // 24h
		logGroup = 'ext.wikia.adEngine.slot.resolvedState',
		now = win.wgNow || new Date(),
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

	function wasRecentlySeen(record) {
		var age;

		if (record) {
			age = now.getTime() - record.lastSeenDate;

			if (age > 0 || age < cacheTtl) {
				return true;
			}
		}

		return false;
	}

	function checkAndUpdateStorage() {
		var adId = uapContext.getUapId(),
			adCacheKey = cacheKey + '_' + adId,
			record = cache.get(adCacheKey, now);

		if (wasRecentlySeen(record) && record.lastSeenDate !== now.getTime()) {
			log('Full version of uap was seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);

			return false;
		} else {
			log('Full version of uap was not seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);

			cache.set(adCacheKey, {
				adId: adId,
				lastSeenDate: now.getTime()
			}, cacheTtl);

			return true;
		}
	}

	function hasResolvedState(params) {
		return paramsAreCorrect(params) && !isBlockedByURLParam() &&
			(
				checkAndUpdateStorage() ||
				isForcedByURLParam()
			);
	}

	function setResolvedState(params) {
		log('Resolved state is turned on', logGroup, log.levels.debug);
		if (params.backgroundImage) {
			params.aspectRatio = params.resolvedState.aspectRatio;
			params.backgroundImage.src = params.resolvedState.imageSrc;
		} else {
			params.aspectRatio = params.resolvedStateAspectRatio;
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
