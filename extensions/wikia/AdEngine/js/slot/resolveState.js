/* global define */
define('ext.wikia.adEngine.slot.resolveState', [
	'ext.wikia.adEngine.context.uapContext',
	'wikia.cache',
	'wikia.log',
	'wikia.querystring'
], function (uapContext, cache, log, QueryString) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.resolveState',
		qs = new QueryString(),
		cacheKey = 'adEngine_resolvedStateCounter',
		cacheTtl = 24 * 3600 * 1000, // 24h
		now = window.wgNow || new Date();

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
		return params.resolvedState.aspectRatio > 0 && params.resolvedState.imageSrc !== '';
	}

	function hasResolvedState(params) {
		return paramsAreCorrect(params) && !isBlockedByURLParam() &&
			(
				checkAndUpdateStorage() ||
				isForcedByURLParam()
			);
	}

	function setResolveState(params) {
		log('Resolved state is turned on', log.levels.debug, logGroup);
		params.backgroundImage.src = params.resolvedState.imageSrc;
		params.aspectRatio = params.resolvedState.aspectRatio;

		return params;
	}

	function templateSupportsResolveState(params) {
		return params.backgroundImage;
	}

	function setDefaultState(params) {
		params.backgroundImage.src = params.imageSrc;
		return params;
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
		var age, val,
			adId = uapContext.getUapId(),
			adCacheKey = cacheKey + '_' + adId,
			record = cache.get(adCacheKey, now);

		if (wasRecentlySeen(record)) {
			log('Full version of uap was seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);

			return false;
		} else {
			log('Full version of uap was not seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);

			val = {
				adId: adId,
				lastSeenDate: now.getTime()
			};

			age = now.getTime() - val.lastSeenDate;
			cache.set(adCacheKey, val, cacheTtl - age, now);


			return true;
		}
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
