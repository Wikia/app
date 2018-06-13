import {inject as service} from '@ember/service';
import {alias} from '@ember/object/computed';
import Component from '@ember/component';
import {computed} from '@ember/object';
// it's from in-repo addon
import wrapMeHelper from '../../helpers/wrap-me';
import NewReplyNotificationMixin from '../../mixins/new-reply-notification';
import PostUpvoteNotificationMixin from '../../mixins/post-upvote-notification';
import ReplyUpvoteNotificationMixin from '../../mixins/reply-upvote-notification';
import MarkAsReadNotificationMixin from '../../mixins/mark-as-read-notification';
import notificationTypes from '../../utils/notification-types';
import extend from '../../utils/extend';

export default Component.extend(
	NewReplyNotificationMixin,
	PostUpvoteNotificationMixin,
	ReplyUpvoteNotificationMixin,
	MarkAsReadNotificationMixin,
	{
		i18n: service(),
		logger: service(),
		notifications: service(),

		classNames: ['wds-notification-card'],
		classNameBindings: ['isUnread:wds-is-unread'],
		tagName: 'li',

		isUnread: alias('model.isUnread'),

		iconName: computed('model.type', function () {
			const type = this.get('model.type');

			if (this.isDiscussionReply(type)) {
				return 'wds-icons-reply-small';
			} else if (this.isAnnouncement(type)) {
				return 'wds-icons-megaphone';
			} else {
				return 'wds-icons-upvote-small';
			}
		}),

		postTitleMarkup: computed('model.title', function () {
			return wrapMeHelper.compute([
				this.get('model.title')
			], {
				tagName: 'b',
			});
		}),

		showSnippet: computed('model.{title,type}', function () {
			return !this.get('model.title') && this.isAnnouncement(this.get('model.type')) !== true;
		}),

		showLastActor: computed('model.type', function () {
			return this.isAnnouncement(this.get('model.type')) === true;
		}),

		postSnippetMarkup: computed('model.snippet', function () {
			return wrapMeHelper.compute([
				this.get('model.snippet')
			], {
				tagName: 'i',
			});
		}),

		text: computed('model', function () {
			const model = this.get('model');
			const type = model.type;

			if (this.isDiscussionReply(type)) {
				return this.getReplyMessageBody(model);
			} else if (this.isDiscussionPostUpvote(type)) {
				return this.getPostUpvoteMessageBody(model);
			} else if (this.isDiscussionReplyUpvote(type)) {
				return this.getReplyUpvoteMessageBody(model);
			} else if (this.isAnnouncement(type)) {
				return model.title;
			} else {
				this.get('logger').warn('No type found for a notification', model);
			}
		}),

		showAvatars: computed('model.{totalUniqueActors,type}', function () {
			return this.get('model.totalUniqueActors') > 2 &&
				this.isDiscussionReply(this.get('model.type'));
		}),

		avatars: computed('model', function () {
			const avatars = [];
			const latestActors = this.get('model.latestActors') || [];

			latestActors.forEach((actor) => {
				avatars.push({
					src: actor.avatarUrl,
					link: `/wiki/User:${actor.name}`
				});
			});
			return avatars;
		}),

		actions: {
			onNotificationClicked() {
				// trackClick(this.get('model'));
			}
		},

		isDiscussionReply(type) {
			return type === notificationTypes.discussionReply;
		},

		isDiscussionReplyUpvote(type) {
			return type === notificationTypes.discussionUpvoteReply;
		},

		isDiscussionPostUpvote(type) {
			return type === notificationTypes.discussionUpvotePost;
		},

		isAnnouncement(type) {
			return type === notificationTypes.announcement;
		},

		getTranslatedMessage(key, context) {
			const fullContext = extend({}, {
				ns: 'design-system',
			}, context);

			return this.get('i18n').t(key, fullContext);
		},
	}
);
