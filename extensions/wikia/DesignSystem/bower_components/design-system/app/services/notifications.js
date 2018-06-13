import {getOwner} from '@ember/application';
import Service, {inject as service} from '@ember/service';

import NotificationsModel from '../models/notifications/notifications';

export default Service.extend({
	model: null,
	isLoading: false,
	nextPage: null,

	currentUser: service(),
	logger: service(),

	/**
	 * @returns {void}
	 */
	init() {
		this._super(...arguments);

		this.set('model', NotificationsModel.create(getOwner(this).ownerInjection()));
	},

	didInsertElement() {
		this._super(...arguments);

		this.loadUnreadNotificationCount();
	},

	loadUnreadNotificationCount() {
		return this.get('model').loadUnreadNotificationCount()
		.catch((err) => {
			this.get('logger').warn(`Couldn't load notification count`, err);
		});
	},

	loadFirstPage() {
		if (this.get('isLoading') === true
			|| this.get('nextPage') !== null
			|| this.get('firstPageLoaded') === true) {
			return;
		}
		this.set('firstPageLoaded', true);
		this.set('isLoading', true);
		this.get('model')
			.loadFirstPageReturningNextPageLink()
			.then((nextPage) => {
				this.set('nextPage', nextPage);
			})
			.catch((err) => {
				this.get('logger').warn(`Couldn't load first page`, err);
			})
			.then(() => {
				this.set('isLoading', false);
			});
	},

	loadNextPage() {
		if (this.get('isLoading') === true
			|| this.get('nextPage') === null) {
			return;
		}
		this.set('isLoading', true);

		this.get('model')
			.loadPageReturningNextPageLink(this.get('nextPage'))
			.then((nextPage) => {
				this.set('nextPage', nextPage);
			})
			.catch((err) => {
				this.get('logger').warn(`Couldn't load more notifications`, err);
			})
			.then(() => {
				this.set('isLoading', false);
			});
	},

	markAllAsRead() {
		this.get('model').markAllAsRead();
	},

	markAsRead(notification) {
		this.get('model').markAsRead(notification);
	},

	getUnreadCount() {
		return this.get('model.unreadCount');
	}

});
