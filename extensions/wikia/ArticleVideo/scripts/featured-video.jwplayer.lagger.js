define('wikia.articleVideo.featuredVideo.lagger', [
	'ext.wikia.adEngine.adContext',
	'wikia.lazyqueue',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (adContext, lazyQueue, mercuryListener) {
	'use strict';

	var hasResponse = false,
		onResponseCallbacks = [],
		lastAdLineItemId = null;

	function addResponseListener(callback) {
		onResponseCallbacks.push(callback);
	}

	function getName() {
		return 'featuredVideo';
	}

	function isEnabled() {
		return adContext.get('opts.isFVDelayEnabled') && adContext.get('targeting.hasFeaturedVideo');
	}

	function markAsReady(lineItemId) {
		lastAdLineItemId = lineItemId;

		if (!hasResponse) {
			hasResponse = true;
			onResponseCallbacks.start();
		}
	}

	function resetState() {
		hasResponse = false;
		onResponseCallbacks = [];
		lazyQueue.makeQueue(onResponseCallbacks, function (callback) {
			callback(lastAdLineItemId);
		});
	}

	resetState();

	if (mercuryListener) {
		mercuryListener.onEveryPageChange(resetState);
	}

	return {
		addResponseListener: addResponseListener,
		getName: getName,
		markAsReady: markAsReady,
		wasCalled: isEnabled
	};
});
