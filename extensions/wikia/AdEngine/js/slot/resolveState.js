/* global define */
define('ext.wikia.adEngine.slot.resolveState', [
	'wikia.log',
	'wikia.querystring',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'wikia.cache',
	'ext.wikia.adEngine.context.uapContext'
], function (log, QueryString, pvCounter, cache, uapContext) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.resolveState',
		qs = new QueryString(),
		wasAlreadyPlayedOnce = false,
		cacheKey = 'adEngine_resolveStateCounter',
		cacheTtl = 24 * 3600 * 1000, // 1 day to clear the page view counter
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
		return params.resolveState.aspectRatio > 0 && params.resolveState.imageSrc !== '';
	}

	function hasResolvedState(params) {
		return paramsAreCorrect(params) &&
			(
				checkAndUpdateStorage(params) ||
				isForcedByURLParam() ||
				!isBlockedByURLParam()
			);
	}

	function setResolveState(params) {
		log('Resolved state is turned on', log.levels.debug, logGroup);
		params.backgroundImage.src = params.resolveState.imageSrc;
		params.aspectRatio = params.resolveState.aspectRatio;

		wasAlreadyPlayedOnce = true;

		return params;
	}

	function templateSupportsResolveState(params) {
		return params.backgroundImage;
	}

	function setDefaultState(params) {
		params.backgroundImage.src = params.imageSrc;
		return params;
	}

	/**
	 * Check if ad with given adId has been seen in full state
	 * during last cacheTtl period of time.
	 *
	 * @param records array of records in localStorage
	 * @param adId
	 * @returns {boolean}
	 */
	function wasRecentlySeen(records, adId) {
		var recentlySeenObj = null;

		records.forEach(function(value) {
			if (value.adId == adId) {
				recentlySeenObj = value;
			}
		});

		if (recentlySeenObj) {
			var age = now.getTime() - recentlySeenObj.lastSeenDate;

			if (age > 0 || age < cacheTtl) {
				return true;
			}
		}

		return false;
	}

	function checkAndUpdateStorage(params) {
		var age, val, records = cache.get(cacheKey, now) || [];

		if (wasRecentlySeen(records, params.uap)) {
			log('Full version of uap was seen in last 24h. adId: ' + params.uap, log.levels.debug, logGroup);
			return false;
		} else {
			log('Full version of uap was not seen in last 24h. adId: ' + params.uap, log.levels.debug, logGroup);

			val = {
				adId: uapContext.getUapId() || params.uap,
				lastSeenDate: now.getTime()
			};
			records.push(val);

			log('Setting new value in localStorage for adId: ' + params.uap, log.levels.debug, logGroup);

			age = now.getTime() - val.lastSeenDate;
			cache.set(cacheKey, records, cacheTtl - age, now);

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
