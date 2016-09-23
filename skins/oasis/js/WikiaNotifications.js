var WikiaNotificationsApp = {
	purgeCurrentPage: function() {
			$.post(wgScript, {action: 'purge', title: wgPageName});
	},

	track: Wikia.Tracker.buildTrackingFunction({
		category: 'sitewidemessages',
		trackingMethod: 'analytics'
	}),

	init: function() {
		var self = this,
			notifications = $('#WikiaNotifications');

		// handle clicks on dismiss icons
		notifications.find('.close-notification').click(function(ev) {
			// find notification to be removed
			var notification = $(this).parent();

			// check the type of removed notification
			var notificationType = parseInt(notification.attr('data-type'));

			switch (notificationType) {
				// dismiss talk page message notification
				case 1:
					$.post(wgScript, {action: 'ajax', rs: 'wfDismissWikiaNewtalks'}, WikiaNotificationsApp.purgeCurrentPage);

					// remove wrapping <li>
					notification.parent().remove();
					break;

				// dismiss community message notification
				case 2:
					$.post(wgScript, {action: 'ajax', rs: 'CommunityMessagesAjax', method: 'dismissMessage'}, WikiaNotificationsApp.purgeCurrentPage);

					// remove wrapping <li>
					notification.parent().remove();
					break;

				// dismiss sitewide messages
				case 5:
					var messageId = parseInt(notification.attr('id').substr(4));
					var nextNotification = notification.next();

					$.post(wgScript, {title: 'Special:SiteWideMessages', action: 'dismiss', mID: messageId}, WikiaNotificationsApp.purgeCurrentPage);

					// SWM click tracking (BugID: 45402)
					self.track({
						action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
						browserEvent: ev,
						label: 'swm-dismiss',
						value: messageId
					});

					// remove <div>
					notification.remove();
					nextNotification.css("display", "block");
					// Track impression for the next SWM being displayed after a previous one was dismissed
					if ( nextNotification.length ) {
						var	nextMessageId = parseInt( nextNotification.attr( 'id' ).substr( 4 ) );

						self.track({
							action: Wikia.Tracker.ACTIONS.IMPRESSION,
							label: 'swm-impression',
							value: nextMessageId
						});
					}
					break;

				// dismiss custom notifications
				case 10:
					$.post($(this).attr('data-url'), WikiaNotificationsApp.purgeCurrentPage);

					// remove wrapping <li>
					notification.parent().remove();
					break;

				default:
					// remove wrapping <li>
					notification.parent().remove();
					break;
			}
		});
	}
};

$(function() {
	WikiaNotificationsApp.init();
});
