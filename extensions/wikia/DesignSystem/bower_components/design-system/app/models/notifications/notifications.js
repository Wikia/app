import RSVP from 'rsvp';

import {getOwner} from '@ember/application';
import {A} from '@ember/array';
import {inject as service} from '@ember/service';
import EmberObject, {get} from '@ember/object';

import Notification from './notification';
import {convertToIsoString} from '../../utils/iso-date-time';

export default EmberObject.extend({
	fetch: service(),
	logger: service(),

	unreadCount: 0,
	data: null,

	init() {
		this._super(...arguments);
		this.set('data', A());
	},

	getNewestNotificationISODate() {
		return convertToIsoString(this.get('data.0.timestamp'));
	},

	loadFirstPageReturningNextPageLink() {
		return this.get('fetch').fetchFromOnSiteNotifications('notifications')
		.then((data) => {
			this.addNotifications(data.notifications);
			return this.getNext(data);
		});
	},

	loadPageReturningNextPageLink(page) {
		return this.get('fetch').fetchFromOnSiteNotifications(page)
			.then((data) => {
				this.addNotifications(data.notifications);
				return this.getNext(data);
			});
	},

	getNext(data) {
		return get(data, '_links.next') || null;
	},

	markAsRead(notification) {
		if (!notification.isUnread) {
			return RSVP.reject();
		}

		return notification.markAsRead()
			.then(() => {
				this.decrementProperty('unreadCount');
			});
	},

	markAllAsRead() {
		const since = this.getNewestNotificationISODate();

		return this.get('fetch').fetchFromOnSiteNotifications(`notifications/mark-all-as-read`, {
			body: JSON.stringify({since}),
			headers: {
				'Content-Type': 'application/json'
			},
			method: 'POST',
		}).then(() => {
			this.get('data').setEach('isUnread', false);
			this.set('unreadCount', 0);
		});
	},

	addNotifications(notifications) {
		const notificationModels = notifications.map((notificationApiData) => {
			const notification = Notification.create(getOwner(this).ownerInjection());
			notification.setNormalizedData(notificationApiData);

			return notification;
		});

		this.get('data').pushObjects(notificationModels);
	},

	/**
	 * @private
	 * @param model
	 * @return {Promise.<T>}
	 */
	loadUnreadNotificationCount() {
		return this.get('fetch').fetchFromOnSiteNotifications('notifications/unread-count')
			.then((result) => {
				this.set('unreadCount', result.unreadCount);
			}).catch((error) => {
				this.set('unreadCount', 0);
				this.get('logger')
					.error('Setting notifications unread count to 0 because of the API fetch error', error);
			});
	}

});
