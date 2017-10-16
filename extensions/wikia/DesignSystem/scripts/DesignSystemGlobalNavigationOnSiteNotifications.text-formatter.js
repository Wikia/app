define('ext.wikia.design-system.on-site-notifications.text-formatter', [
		'wikia.window',
		'ext.wikia.design-system.on-site-notifications.common'
	], function (window, c) {
		'use strict';

		function TextFormatter() {
			function escape(text) {
				return text ? window.mw.html.escape(String(text)) : '';
			}

			function bold(text) {
				return '<b>' + text + '</b>';
			}

			function fillArgs(message, args) {
				return Object.keys(args).reduce(function (acc, key) {
					return acc.replace('{' + key + '}', args[key])
				}, message);
			}

			function getMessage(key) {
				// TODO IRIS-4975 use mw.message(key).parse()
				return window.mw.messages.get(key);
			}

			this.getText = function (notification) {
				if (notification.type === c.notificationTypes.discussionReply) {
					return this._getReplyText(notification);
				} else if (notification.type === c.notificationTypes.discussionUpvotePost) {
					return this._getPostUpvoteText(notification)
				} else if (notification.type === c.notificationTypes.discussionUpvoteReply) {
					return this._getReplyUpvoteText(notification);
				} else {
					return notification.title;
				}
			};

			this._getReplyText = function (notification) {
				var key = this._getReplyKey(notification.title, notification.totalUniqueActors),
					message = getMessage(key),
					args = {postTitle: bold(escape(notification.title))};

				if (notification.totalUniqueActors > 2) {
					args.mostRecentUser = escape(notification.latestActors[0].name);
					args.number = escape(notification.totalUniqueActors - 1);
				} else if (notification.totalUniqueActors === 2) {
					args.firstUser = escape(notification.latestActors[0].name);
					args.secondUser = escape(notification.latestActors[1].name);
				} else {
					args.user = escape(notification.latestActors[0].name);
				}

				return fillArgs(message, args);
			};

			this._getReplyKey = function (title, totalUniqueActors) {
				var user = totalUniqueActors <= 1 ? '' :
					totalUniqueActors === 2 ? 'two-users-' : 'multiple-users-';
				return 'notifications-replied-by-' + user + (title ? 'with-title' : 'no-title');
			};

			this._getPostUpvoteText = function (notification) {
				var key = 'notifications-post-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				var message = getMessage(key);
				return fillArgs(message, {
					postTitle: bold(escape(notification.title)),
					number: escape(notification.totalUniqueActors)
				});
			};

			this._getReplyUpvoteText = function (notification) {
				var key = 'notifications-reply-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				var message = getMessage(key);
				return fillArgs(message, {
					postTitle: bold(escape(notification.title)),
					number: escape(notification.totalUniqueActors)
				});
			};

			this._getUpvoteKey = function (title, totalUniqueActors) {
				return '-' + (totalUniqueActors <= 1 ? 'single-user' : 'multiple-users')
					+ '-' + (title ? 'with-title' : 'no-title');
			};
		}

		return TextFormatter
	}
);
