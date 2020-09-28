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
				} else if (notification.type === c.notificationTypes.announcement) {
					return escape(notification.snippet);
				} else if (notification.type === c.notificationTypes.threadAtMention) {
					return this._getThreadAtMentionText(notification)
				} else if (notification.type === c.notificationTypes.postAtMention) {
					return this._getPostAtMentionText(notification)
				} else if (notification.type = c.notificationTypes.talkPageMessage) {
					return this._getTalkPageMessageText(notification);
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
				if (totalUniqueActors <= 1) {
					return title ? 'notifications-replied-by-with-title' : 'notifications-replied-by-no-title';
				}

				if (totalUniqueActors === 2) {
					return title ?
						'notifications-replied-by-two-users-with-title' :
						'notifications-replied-two-users-by-no-title';
				}

				return title ?
					'notifications-replied-by-multiple-users-with-title' :
					'notifications-replied-by-multiple-users-no-title';
			};

			this._getPostUpvoteText = function (notification) {
				var message = getMessage(this._getPostUpvoteKey(notification.title, notification.totalUniqueActors));
				return fillArgs(message, {
					postTitle: bold(escape(notification.title)),
					number: escape(notification.totalUniqueActors)
				});
			};

			this._getReplyUpvoteText = function (notification) {
				var message = getMessage(this._getReplyUpvoteKey(notification.title, notification.totalUniqueActors));
				return fillArgs(message, {
					postTitle: bold(escape(notification.title)),
					number: escape(notification.totalUniqueActors)
				});
			};

			this._getThreadAtMentionText = function (notification) {
				var message = getMessage('notifications-post-at-mention');
				return fillArgs(message, {
					mentioner: escape(notification.latestActors[0].name),
					postTitle: bold(escape(notification.title))
				});
			};

			this._getPostAtMentionText = function (notification) {
				var message = getMessage('notifications-reply-at-mention');
				return fillArgs(message, {
					mentioner: escape(notification.latestActors[0].name),
					postTitle: bold(escape(notification.title))
				});
			};

			this._getPostUpvoteKey = function (title, totalUniqueActors) {
				if (totalUniqueActors <= 1) {
					return title ?
						'notifications-post-upvote-single-user-with-title' :
						'notifications-post-upvote-single-user-no-title';
				}

				return title ?
					'notifications-post-upvote-multiple-users-with-title' :
					'notifications-post-upvote-multiple-users-no-title';
			};

			this._getReplyUpvoteKey = function (title, totalUniqueActors) {
				if (totalUniqueActors <= 1) {
					return title ?
						'notifications-reply-upvote-single-user-with-title' :
						'notifications-reply-upvote-single-user-no-title';
				}

				return title ?
					'notifications-reply-upvote-multiple-users-with-title' :
					'notifications-reply-upvote-multiple-users-no-title';
			};

			this._getTalkPageMessageText = function (notification) {
				var userName = ( notification.latestActors[0] && notification.latestActors[0].name ) ?
					escape(notification.latestActors[0].name) :
					getMessage('oasis-anon-user');
				return fillArgs(getMessage('notifications-talk-page-message'), {
					user: userName,
				});
			};
		}

		return TextFormatter
	}
);
