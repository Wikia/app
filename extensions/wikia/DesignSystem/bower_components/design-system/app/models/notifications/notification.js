import {getOwner} from '@ember/application';
import EmberObject, {get} from '@ember/object';
import {A} from '@ember/array';
import {inject as service} from '@ember/service';

import DiscussionContributor from '../discussion/domain/contributor';
import notificationTypes from '../../utils/notification-types';
import {convertToTimestamp} from '../../utils/iso-date-time';

const defaultAvatar = 'https://static.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg' +
	'/revision/latest/scale-to-width-down/50';

export default EmberObject.extend({
	fetch: service(),

	title: null,
	snippet: null,
	timestamp: null,
	communityName: null,
	type: null,
	isUnread: false,
	totalUniqueActors: 1,
	latestActors: null,
	uri: null,

	init() {
		this._super(...arguments);
		this.set('latestActors', A());
	},

	setNormalizedData(notificationData) {
		this.setProperties({
			title: get(notificationData, 'refersTo.title'),
			snippet: get(notificationData, 'refersTo.snippet'),
			uri: get(notificationData, 'refersTo.uri'),
			latestEventUri: get(notificationData, 'events.latestEvent.uri'),
			timestamp: convertToTimestamp(get(notificationData, 'events.latestEvent.when')),
			communityName: get(notificationData, 'community.name'),
			communityId: get(notificationData, 'community.id'),
			isUnread: notificationData.read === false,
			totalUniqueActors: get(notificationData, 'events.totalUniqueActors'),
			latestActors: this.createActors(get(notificationData, 'events.latestActors')),
			type: this.getTypeFromApiData(notificationData)
		});
	},

	createActors(actors) {
		return actors.reduce((array, actor) => {
			if (!actor.avatarUrl) {
				actor.avatarUrl = defaultAvatar;
			}

			const contributor = DiscussionContributor.create(getOwner(this).ownerInjection(), actor);
			array.addObject(contributor);

			return array;
		}, A());
	},

	getTypeFromApiData(apiData) {
		if (apiData.type === 'upvote-notification') {
			if (apiData.refersTo.type === 'discussion-post') {
				return notificationTypes.discussionUpvoteReply;
			} else {
				return notificationTypes.discussionUpvotePost;
			}
		} else if (apiData.type === 'replies-notification') {
			return notificationTypes.discussionReply;
		} else if (apiData.type === 'announcement-notification') {
			return notificationTypes.announcement;
		}
	},

	markAsRead() {
		return this.get('fetch').fetchFromOnSiteNotifications(`/notifications/mark-as-read/by-uri`, {
			body: JSON.stringify([this.get('uri')]),
			headers: {
				'Content-Type': 'application/json'
			},
			method: 'POST',
		}).then(() => {
			this.set('isUnread', false);
		});
	},
});
