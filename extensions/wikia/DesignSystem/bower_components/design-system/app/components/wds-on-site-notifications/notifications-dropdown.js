import Component from '@ember/component';
import {inject as service} from '@ember/service';
import NotificationsUnreadCount from '../../mixins/notifications-unread-count';

export default Component.extend(NotificationsUnreadCount, {
	tagName: '',

	notifications: service(),

	didInsertElement() {
		this._super(...arguments);

		this.get('notifications').loadUnreadNotificationCount();
	},

	actions: {
		onOpen() {
			// TODO tracking
			// trackOpenMenu(this.get('notifications').getUnreadCount());
			this.get('notifications').loadFirstPage();
		}
	}
});
