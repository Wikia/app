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

	function createCacheKey() {
		return cacheKey + '_' + uapContext.getUapId();
	}

	function findRecordInCache() {
		return cache.get(createCacheKey(), now);
	}

	function wasDefaultStateSeen() {
		var adId = uapContext.getUapId(),
			record = findRecordInCache(),
			seen = !!record && record.lastSeenDate !== now.getTime();

		if (seen) {
			log('Full version of uap was seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);
		} else {
			log('Full version of uap was not seen in last 24h. adId: ' + adId, log.levels.debug, logGroup);
		}

		return seen;
	}

	function updateInformationAboutSeenDefaultStateAd() {
		cache.set(createCacheKey(), {
			adId: uapContext.getUapId(),
			lastSeenDate: now.getTime()
		}, cacheTtl, now);
	}

	function setResolvedState(params) {
		log('Resolved state is turned on', logGroup, log.levels.debug);
		params.aspectRatio = params.resolvedStateAspectRatio;
		params.image1.element.src = params.image1.resolvedStateSrc;

		if (params.image2 && params.image2.resolvedStateSrc) {
			params.image2.element.src = params.image2.resolvedStateSrc;
		}
	}

	function templateSupportsResolvedState(params) {
		return !!(params.image1 && params.image1.resolvedStateSrc);
	}

	function setDefaultState(params) {
		params.image1.element.src = params.image1.defaultStateSrc;

		if (params.image2 && params.image2.defaultStateSrc) {
			params.image2.element.src = params.image2.defaultStateSrc;
		}
	}

	function setImage(videoSettings) {
		var params = videoSettings.getParams();

		if (templateSupportsResolvedState(params)) {
			if (videoSettings.isResolvedState()) {
				setResolvedState(params);
			} else {
				setDefaultState(params);
				updateInformationAboutSeenDefaultStateAd();
			}
		}
	}

	function isResolvedState() {
		var showResolvedState = !isBlockedByURLParam(),
			defaultStateSeen = true;

		if (showResolvedState) {
			defaultStateSeen = wasDefaultStateSeen() || isForcedByURLParam();
		}

		return showResolvedState && defaultStateSeen;
	}

	return {
		isResolvedState: isResolvedState,
		setImage: setImage
	};
});
