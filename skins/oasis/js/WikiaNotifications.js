var WikiaNotificationsApp = {

	purgeCurrentPage: function() {
			$.post(wgScript, {action: 'purge', title: wgPageName});
	},

	init: function() {
		var notifications = $('#WikiaNotifications');

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
					var trackObj = {
						ga_category: 'sitewidemessages',
						ga_action: WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
						ga_label: 'swm-dismiss',
						ga_value: messageId
					};
					WikiaTracker.trackEvent(
						'trackingevent',
						trackObj,
						'internal'
					);

					// remove <div>
					notification.remove();
					nextNotification.css("display", "block");
					// Track impression for the next SWM being displayed after a previous one was dismissed
					if ( nextNotification.length ) {
						var	nextMessageId = parseInt( nextNotification.attr( 'id' ).substr( 4 ) ),
							impTrackObj = {
								ga_category: 'sitewidemessages',
								ga_action: WikiaTracker.ACTIONS.IMPRESSION,
								ga_label: 'swm-impression',
								ga_value: nextMessageId
							};
						WikiaTracker.trackEvent(
							'trackingevent',
							impTrackObj,
							'internal'
						);
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

	$('body').on({
		'meebo-visible': function() {
			$('#WikiaNotifications').addClass('meebo');
		},
		'meebo-hidden': function() {
			$('#WikiaNotifications').removeClass('meebo');
		}
	});
});
