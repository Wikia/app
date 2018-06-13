import {inject as service} from '@ember/service';
import {oneWay, or} from '@ember/object/computed';
import Component from '@ember/component';
import NotificationsUnreadCount from '../../mixins/notifications-unread-count';
import MarkAllNotificationsMixin from '../../mixins/mark-all-notifications';
// import {trackOpenMenu} from '../../utils/tracking/notifications-tracker';

export default Component.extend(NotificationsUnreadCount, MarkAllNotificationsMixin, {
	notifications: service(),

	notificationsList: oneWay('notifications.model.data'),
	isNotificationsListVisible: or('notificationsList.length', 'notifications.isLoading'),
});
