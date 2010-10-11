$(function() {
	WikiaNotificationsApp.init();
});

WikiaNotificationsApp = {

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

					// remove <div>
					notification.remove();
					nextNotification.css("display", "block");
					break;

				// dismiss custom notifications
				case 10:
					$.post($(this).attr('data-url'), WikiaNotificationsApp.purgeCurrentPage);

					// remove wrapping <li>
					notification.parent().remove();

				default:
					// remove wrapping <li>
					notification.parent().remove();
					break;
			}
		});

		// tracking of shown notifications
		notifications.children('li').each(function() {
			var notification = $(this).children();

			$.tracker.byStr('notifications/' + WikiaNotificationsApp.getNotificationType(notification) + '/view');
		});

		// track clicks on links inside notifications
		notifications.click(function(ev) {
			var node = $(ev.target);

			if (node.is('a')) {
				var notification = node.closest('div');
				var eventName = node.hasClass('close-notification') ? 'dismiss' : 'link';

				$.tracker.byStr('notifications/' + WikiaNotificationsApp.getNotificationType(notification) + '/' + eventName);
			}
		});
	},

	// get notification type name
	getNotificationType: function(notification) {
		var type = parseInt(notification.attr('data-type'));

		switch(parseInt(type)) {
			case 1:
				return 'newmessage';
			case 2:
				return 'communitymessages';
			case 3:
				return 'achievement';
			case 4:
				return 'editsimilar';
			case 5:
				return 'sidewidemessages';
			case 10:
				return notification.attr('data-name');
		}

		return false;
	}
};