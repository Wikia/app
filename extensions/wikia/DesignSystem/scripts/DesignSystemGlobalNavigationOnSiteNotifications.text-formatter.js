define('ext.wikia.design-system.on-site-notifications.text-formatter', [
		'wikia.window',
		'ext.wikia.design-system.on-site-notifications.common'
	], function (window, c) {
		'use strict';

		function TextFormatter() {
			function bold(text) {
				return text ? '<b>' + text + '</b>' : text;
			}

			function fillArgs(message, args) {
				return Object.keys(args).reduce(function (acc, key) {
					return acc.replace('__' + key + '__', args[key])
				}, message);
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
					message = window.mw.message(key).parse(),
					args = {
						postTitle: bold(notification.title)
					};

				if (notification.totalUniqueActors > 2) {
					args.mostRecentUser = notification.latestActors[0].name;
					args.number = notification.totalUniqueActors - 1;
				} else if (notification.totalUniqueActors == 2) {
					args.firstUser = notification.latestActors[0].name;
					args.secondUser = notification.latestActors[1].name;
				} else {
					args.user = notification.latestActors[0].name;
				}

				return fillArgs(message, args);
			};

			this._getReplyKey = function (title, totalUniqueActors) {
				var user = totalUniqueActors <= 1 ? '' :
					totalUniqueActors == 2 ? 'two-users-' : 'multiple-users-';
				return 'notifications-replied-by-' + user + (title ? 'with-title' : 'no-title');
			};

			this._getPostUpvoteText = function (notification) {
				var key = 'notifications-post-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				var message = window.mw.message(key).parse();
				return fillArgs(message, {postTitle: bold(notification.title)});
			};

			this._getReplyUpvoteText = function (notification) {
				var key = 'notifications-reply-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				var message = window.mw.message(key).parse();
				return fillArgs(message, {postTitle: bold(notification.title)});
			};

			this._getUpvoteKey = function (title, totalUniqueActors) {
				return '-' + (totalUniqueActors <= 1 ? 'single-user' : 'multiple-users')
					+ '-' + (title ? 'with-title' : 'no-title');
			};
		}

		return TextFormatter
	}
);
