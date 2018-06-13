import Component from '@ember/component';
import {inject as service} from '@ember/service';
import {oneWay} from '@ember/object/computed';
import NotificationsScrollMenuMixin from '../../mixins/notifications-scroll-menu';

export default Component.extend(NotificationsScrollMenuMixin, {
	tagName: 'ul',
	notifications: service(),
	classNames: ['wds-notifications__notification-list', 'wds-list', 'wds-has-lines-between'],

	isLoadingNewResults: oneWay('notifications.isLoading'),
	notificationsList: oneWay('notifications.model.data'),
});
