define('ext.wikia.AffiliateService.tracker', [
	'jquery',
	'wikia.tracker',
	'wikia.window',
], function ($, tracker, win) {
	'use strict';

	var defaultOptions = {
		campaignId: '',
		categoryId: '',
		extraTracking: [],
	}

	function track(action, label, options) {
		var currentOptions = $.extend({}, defaultOptions, options || {});

		// convert extra tracking options
		var extraTrackingOptions = {};
		options.extraTracking.forEach((kv) => {
			extraTrackingOptions['affiliation_' + kv.key] = kv.val;
		});

		// add more properties for tracking event
		var computedTracking = $.extend({
			action: action,
			category: 'affiliate_incontent_recommend',
			label: label,
			trackingMethod: 'analytics',
			campaign_id: options.campaignId,
			category_id: options.categoryId,
		}, extraTrackingOptions);

		// set up GA dimensions
		win.guaSetCustomDimension(21, (win.wgArticleId || '').toString());
		win.guaSetCustomDimension(31, (options.campaignId || '').toString());
		win.guaSetCustomDimension(32, (options.categoryId || '').toString());
		win.guaSetCustomDimension(33, Object.keys(extraTrackingOptions).map(function (k) {
			return k + '=' + extraTrackingOptions[k];
		}).join(','));

		console.debug('Affiliate Tracking', computedTracking);

		// send the actual tracking event
		tracker.track(computedTracking);
	}

	function trackClick(label, options) {
		track(tracker.ACTIONS.CLICK, label, options);
	}

	function trackImpression(options) {
		track(tracker.ACTIONS.IMPRESSION, 'affiliate_shown', options);
	}

	function trackLoad(options) {
		track(tracker.ACTIONS.IMPRESSION, 'affiliate_loaded', options);
	}

	function trackNoImpression(options) {
		track(tracker.ACTIONS.NO_IMPRESSION, 'affiliate_not_shown', options);
	}

	return {
		trackImpression: trackImpression,
		trackLoad: trackLoad,
		trackNoImpression: trackNoImpression,
		trackClick: trackClick,
	};
});
