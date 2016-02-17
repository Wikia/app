(function ($, mw, window) {
	'use strict';

	var AnonSiteWideMessages = {
		init: function () {
			$.nirvana.sendRequest({
				controller: 'SiteWideMessagesController',
				method: 'getAnonMessages',
				format: 'json',
				type: 'GET'
			}).done($.proxy(this.handleMessages, this));
		},

		handleMessages: function (data) {
			var i, msgId,
				$siteWideMessage,
				$siteWideMessages,
				$notificationArea = $('#WikiaNotifications'),
				hasNotifications = $notificationArea.length ? 1 : 0,
				cookiePrefix = mw.config.get('wgCookiePrefix') + 'swm-',
				siteMessagesHtml = [],
				firstMessage = true;

			if (data && data.siteWideMessagesCount > 0) {
				for (i in data.siteWideMessages) {
					msgId = data.siteWideMessages[i].msgId;

					// Skip dismissed messages
					if ($.cookie(cookiePrefix + msgId)) {
						continue;
					}

					$siteWideMessage = $('<div>').attr('data-type', data.notificationType)
						.attr('id', 'msg_' + msgId).attr('data-msgid', msgId)
						.on('click', 'p a', $.proxy(this.handleLinkClick, this))
						.append(
							$('<a class="sprite close-notification"></a>')
								.click($.proxy(this.handleClose, this)),
							data.siteWideMessages[i].text
						);

					if (firstMessage === true) {
						firstMessage = msgId;
					} else {
						$siteWideMessage.hide();
					}

					siteMessagesHtml[siteMessagesHtml.length] = $siteWideMessage;
				}

				if (siteMessagesHtml.length > 0) {
					$siteWideMessages = $('<li>').append(siteMessagesHtml);

					if (hasNotifications) {
						$notificationArea.append($siteWideMessages);
					} else {
						$('body').addClass('notifications')
							.append($('<ul id="WikiaNotifications" class="WikiaNotifications"></ul>')
								.append($siteWideMessages));
						$notificationArea = $('#WikiaNotifications');
					}

					// Track first notification impression
					this.track({
						action: window.Wikia.Tracker.ACTIONS.IMPRESSION,
						label: 'swm-impression',
						value: firstMessage
					});

				}

			}
		},

		handleClose: function (ev) {
			var notification = $(ev.currentTarget).parent(),
				messageId = notification.attr('data-msgid'),
				$nextNotification = notification.next(),
				nextMessageId;

			$.cookie(mw.config.get('wgCookiePrefix') + 'swm-' + messageId, 1, {
				'domain': mw.config.get('wgCookieDomain'),
				'expires': 1
			});

			this.track({
				action: window.Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				browserEvent: ev,
				label: 'swm-dismiss',
				value: messageId
			});

			notification.remove();
			$nextNotification.show();

			if ($nextNotification.length) {
				nextMessageId = $nextNotification.attr('data-msgid');

				// Track next message impression
				this.track({
					action: window.Wikia.Tracker.ACTIONS.IMPRESSION,
					label: 'swm-impression',
					value: nextMessageId
				});
			}
		},

		handleLinkClick: function (ev) {
			this.track({
				action: window.Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				browserEvent: ev,
				href: $(ev.currentTarget).attr('href'),
				label: 'swm-link',
				value: $(ev.delegateTarget).attr('data-msgid')
			});
		},

		track: window.Wikia.Tracker.buildTrackingFunction({
			category: 'sitewidemessages',
			trackingMethod: 'analytics'
		})
	};

	$(function () {
		AnonSiteWideMessages.init();
	});

}(jQuery, mediaWiki, this));
