/**
 * LoopNotificationTracking for Insights extension
 * Module sends tracking record to google analytics and internal analytics
 * for events related to BannerNotification appearance and clicks.
 *
 * checks for insights url param to log specific insight type
 * checks for item_status url param to log action status (fixed/notfixed)
 */
define('ext.wikia.Insights.LoopNotificationTracking',
	['jquery', 'wikia.tracker', 'wikia.querystring'],
	function ($, tracker, Querystring) {
		'use strict';

		var qs = new Querystring(),
			insightType = qs.getVal('insights', null),
			itemStatus = qs.getVal('item_status', null);

		/* If there's no itemStatus use action parameter */
		if (itemStatus === null) {
			itemStatus = qs.getVal('action', null);
		}

		/**
		 * Log tracking data on clicks on BannerNotification buttons
		 * @param linkType
		 */
		function onClickTrack(linkType) {
			/* Track a click on an insights type link */
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights-loop-notification',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: insightType+'-'+itemStatus+'-'+linkType.data
			};
			tracker.track(trackingParams);
		}

		/**
		 * Add log for success banner impression if status is fixed
		 */
		function successTrack() {
			if(itemStatus==='fixed') {
				/* Track a click on an insights type link */
				var trackingParams = {
					trackingMethod: 'both',
					category: 'insights-loop-notification',
					action: tracker.ACTIONS.IMPRESSION,
					label: insightType + '-' + itemStatus
				};
				tracker.track(trackingParams);
			}
		}

		function init(event, bannerNotification) {
			/* Setup click events within BannerNotification */
			bannerNotification.$element.find('#InsightsBackToListButton').click('back-to-list', onClickTrack);
			bannerNotification.$element.find('#InsightsNextPageButton').click('next-page', onClickTrack);
			bannerNotification.$element.find('button.close').click('dismiss', onClickTrack);
			successTrack();
		}

		return {
			init: init
		};
	}
);
