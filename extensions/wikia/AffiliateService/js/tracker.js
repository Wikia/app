define('ext.wikia.AffiliateService.tracker', [
	'jquery',
	'wikia.tracker',
	'wikia.window',
], function ($, tracker, win) {
	'use strict';

	var defaultOptions = {
		campaignId: '',
		categoryId: '',
		extraTracking: {},
	}

	function track(action, label, options) {
		var currentOptions = $.extend(defaultOptions, options || {});

		// convert extra tracking options
		var extraTracking = {};
		options.extraTracking.forEach((kv) => {
			extraTracking['affiliation_' + kv.key] = kv.val;
		});

		// add more properties for tracking event
		var computedTracking = $.extend({
			action: action,
			category: 'affiliate_incontent_recommend',
			label: label,
			trackingMethod: 'analytics',
			campaign_id: options.campaignId,
			category_id: options.categoryId,
		}, extraTracking);

		// set up GA dimensions
		win.guaSetCustomDimension(21, win.wgArticleId.toString());
		win.guaSetCustomDimension(31, options.campaignId.toString());
		win.guaSetCustomDimension(32, options.unitId.toString());
		win.guaSetCustomDimension(33, Object.keys(extraTracking).map(function (k) {
			return k + '=' + extraTracking[k];
		}).join(','));

		// send the actual tracking event
		tracker.track(computedTracking);
	}

	function trackClick(label, options) {
		track(tracker.ACTIONS.CLICK, label, options);
	}

	function trackImpression(options) {
		track(tracker.ACTIONS.IMPRESSION, 'affiliate_shown', options);
	}

	function trackNoImpression(options) {
		track(tracker.ACTIONS.NO_IMPRESSION, 'affiliate_not_shown', options);
	}

	return {
		trackImpression: trackImpression,
		trackNoImpression: trackNoImpression,
		trackClick: trackClick,
	};
});
