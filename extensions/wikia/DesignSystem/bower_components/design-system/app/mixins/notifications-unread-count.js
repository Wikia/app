import {gt} from '@ember/object/computed';
import Mixin from '@ember/object/mixin';
import {computed} from '@ember/object';

export default Mixin.create({
	unreadCount: computed('notifications.model.unreadCount', function () {
		const count = this.get('notifications.model.unreadCount');
		if (count > 99) {
			return '99+';
		} else {
			return count;
		}
	}),
	hasUnread: gt('notifications.model.unreadCount', 0),
});
