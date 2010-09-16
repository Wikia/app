$(function() {
	WikiaNotifications.init();
});

WikiaNotifications = {

	purgeCurrentPage: function() {
			$.post(wgScript, {action: 'purge', title: wgPageName});
	},

	init: function() {
		var notifications = $('#WikiaNotifications');

		// handle clicks on dismiss icons
		notifications.find('.close').click(function(ev) {
			// find notification to be removed
			var notification = $(this).parent();

			// check the type of removed notification
			var notificationType = parseInt(notification.attr('data-type'));

			switch (notificationType) {
				// dismiss talk page message notification
				// TODO: refactor - send only single AJAX request dismissing all messages at once
				case 1:
					// get links to talk pages
					var links = notification.find('a').not('.close');

					links.each(function() {
						var href = $(this).attr('href');
						//href += (href.indexOf('?') > -1 ? '&' : '?') + 'action=render'; // this one will cached by varnish

						// request each link, so talk page message will be removed
						$('<iframe>', {'src': href}).
							hide().
							appendTo('body');
					});

					WikiaNotifications.purgeCurrentPage();

					// remove wrapping <li>
					notification.parent().remove();
					break;

				// dismiss community message notification
				case 2:
					$.post(wgScript, {action: 'ajax', rs: 'CommunityMessagesAjax', method: 'dismissMessage'}, WikiaNotifications.purgeCurrentPage);

					// remove wrapping <li>
					notification.parent().remove();
					break;

				// dismiss sitewide messages
				case 5:
					var messageId = parseInt(notification.attr('id').substr(4));
					$.post(wgScript, {title: 'Special:SiteWideMessages', action: 'dismiss', mID: messageId}, WikiaNotifications.purgeCurrentPage);

					// remove wrapping <li>
					notification.remove();
					break;

				default:
					// remove wrapping <li>
					notification.parent().remove();
					break;
			}
		});

		// tracking of shown notifications
		notifications.children('li').each(function() {
			var notification = $(this).children();
			var notificationType = notification.attr('data-type');

			$.tracker.byStr('notifications/' + WikiaNotifications.getTypeById(notificationType) + '/view');
		});

		// track clicks on links inside notifications
		notifications.click(function(ev) {
			var node = $(ev.target);

			if (node.is('a')) {
				var notification = node.closest('div');
				var notificationType = parseInt(notification.attr('data-type'));

				var eventName = node.hasClass('close') ? 'dismiss' : 'link';
				$.tracker.byStr('notifications/' + WikiaNotifications.getTypeById(notificationType) + '/' + eventName);
			}
		});
	},

	// get notification type name based on given type ID (used by tracking code)
	getTypeById: function(type) {
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
		}

		return false;
	}
};