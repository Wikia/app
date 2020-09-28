define('ext.wikia.design-system.on-site-notifications.common', [], function () {
		'use strict';

		var notificationTypes = {
			discussionUpvotePost: 'discussion-upvote-post',
			discussionUpvoteReply: 'discussion-upvote-reply',
			discussionReply: 'discussion-reply',
			announcement: 'announcement',
			postAtMention: 'post-at-mention',
			threadAtMention: 'thread-at-mention',
			talkPageMessage: 'talk-page-message'
		}, logTag = 'on-site-notifications';

		return {
			notificationTypes: notificationTypes,
			logTag: logTag
		}
	}
);
