/**
 * LoopNotificationTracking for Insights extension
 * Module sends tracking record to google analytics and internal analytics
 * for events related to BannerNotification appearance and clicks.
 *
 * checks for insights url param to log specific insight type
 * checks for item_status url param to log action status (fixed/notfixed)
 * TODO add tracking of close button of BannerNotification
 */
define('ext.wikia.Insights.LoopNotificationTracking',
	['jquery', 'wikia.tracker', 'wikia.querystring'],
	function ($, tracker, Querystring) {
		'use strict';

		var qs = new Querystring(),
			insightType = qs.getVal('insights', null),
			isFixed = qs.getVal('item_status', null);

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
				label: insightType+'-'+isFixed+'-'+linkType.data
			};
			tracker.track(trackingParams);
		}

		function init(event, bannerNotification) {
			/* Setup click events within BannerNotification */
			bannerNotification.$element.find('#InsightsBackToListButton').click('back-to-list', onClickTrack);
			bannerNotification.$element.find('#InsightsNextPageButton').click('next-page', onClickTrack);
		}

		return {
			init: init
		};
	}
);
