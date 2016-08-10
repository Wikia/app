require([
	'wikia.nirvana',
	'jquery',
	'BannerNotification',
	'wikia.tracker'
], function (nirvana, $, BannerNotification, tracker)	{
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'contribution-appreciation',
		trackingMethod: 'analytics'
	});

	function setUserNotified() {
		nirvana.sendRequest({
			controller: 'RevisionUpvotesApi',
			method: 'setUserNotified',
			type: 'post',
			data: {
				token: mw.user.tokens.get('editToken')
			}
		});
	}

	function bindClickTracking(notification) {
		notification.$element.on('mousedown', 'a', function () {
			track({
				label: $(this).data('tracking')
			});
		});

		notification.onClose(function () {
			track({
				label: 'notification-close'
			});
		});
	}

	function bindEvents(notification) {
		notification.$element.one('click', '.expand-link', function (e) {
			e.delegateTarget.classList.add('expanded');
		})
	}

	function trackImpression() {
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'notification'
		});
	}

	function getAppreciations() {
		nirvana.sendRequest({
			controller: 'ContributionAppreciation',
			method: 'getAppreciations',
			type: 'get',
			format: 'html',
			callback: function (html) {
				if (html) {
					var notification = new BannerNotification(html, 'appreciation-banner');
					notification.show();
					bindClickTracking(notification);
					trackImpression();
					bindEvents(notification);
					// setUserNotified();
				}
			}
		});
	}

	$(getAppreciations);
});
