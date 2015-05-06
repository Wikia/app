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
			track,
			isEdit = false,
			isFixed = false,
			notificationType,
			status,
			insightType = qs.getVal('insights', null);

		track = Wikia.Tracker.buildTrackingFunction({
			category: 'insights-loop-notification',
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.CLICK_LINK_TEXT
		});

		/**
		 * Log tracking data on clicks on BannerNotification buttons
		 * @param object e
		 */
		function linkTrack(e) {
			var action,
				$target = $(e.target);

			if(e.type === 'keydown' && e.keyCode !== 13) {
				return;
			}

			if ($target.hasClass('close')) {
				action = 'dismiss';
			} else {
				action = $target.attr('data-type');
			}

			track({
				label: insightType + '-' + status + '-' + action
			});
		}

		/**
		 * Add log for success banner impression if status is fixed
		 * @param object $nextPageButton
		 */
		function successTrack() {
			if(isFixed) {
				track({
					action: tracker.ACTIONS.IMPRESSION,
					label: insightType + '-' + status
				});
			}
		}

		function setStatus() {
			if (isEdit) {
				status = 'edit';
			} else {
				status = notificationType;
			}
		}

		function init() {
			$('#WikiaPage').on('mousedown keydown', '.banner-notification a, .banner-notification .close', linkTrack);
			successTrack();
		}

		function setParams(edit, fixed, type) {
			isEdit = edit;
			isFixed = fixed;
			notificationType = type;

			setStatus();
		}

		return {
			init: init,
			setParams: setParams
		};
	}
);
