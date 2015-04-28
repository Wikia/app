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

		/* If there's no itemStatus use action parameter
		 * when item status is empty and action not we're in edit mode
		 */
		if (itemStatus === null) {
			itemStatus = qs.getVal('action', null);
		}

		/**
		 * Log tracking data on clicks on BannerNotification buttons
		 * @param object e
		 */
		function linkTrack(e) {
			/* Track a click on an insights type link */
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights-loop-notification',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: insightType + '-' + itemStatus + '-' + e.data
			};
			tracker.track(trackingParams);
		}

		function onKeydownTrack(e) {
			if(e.keyCode === 13) {// Enter keycode
				linkTrack(e);
			}
		}

		/**
		 * Add log for success banner impression if status is fixed
		 * @param object $nextPageButton
		 */
		function successTrack($nextPageButton) {
			var statusToLog;
			if(itemStatus==='fixed') {
				if ($nextPageButton.length===0) {
					/* Next button doesn't exist - log all done success */
					statusToLog = 'alldone';
				} else {
					/* Next button exists - log regular fixed success */
					statusToLog = itemStatus;
				}
				var trackingParams = {
					trackingMethod: 'both',
					category: 'insights-loop-notification',
					action: tracker.ACTIONS.IMPRESSION,
					label: insightType + '-' + statusToLog
				};
				tracker.track(trackingParams);
			}
		}

		function init(event, bannerNotification) {
			var $nextPageButton = bannerNotification.$element.find('#InsightsNextPageButton'),
				$backToListButton = bannerNotification.$element.find('#InsightsBackToListButton'),
				$closeButton = bannerNotification.$element.find('button.close');
			/* Setup click events within BannerNotification - using mousedown and keydown for earlier detect */
			$backToListButton.mousedown('back-to-list', linkTrack);
			$backToListButton.keydown('back-to-list', onKeydownTrack);
			$nextPageButton.mousedown('next-page', linkTrack);
			$nextPageButton.keydown('next_page', onKeydownTrack);
			$closeButton.mousedown('dismiss', linkTrack);
			$closeButton.keydown('dismiss', onKeydownTrack);
			successTrack($nextPageButton);
		}

		return {
			init: init
		};
	}
);
