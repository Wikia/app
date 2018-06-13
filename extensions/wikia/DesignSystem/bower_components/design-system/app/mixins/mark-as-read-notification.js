import Mixin from '@ember/object/mixin';
// import {trackMarkAsRead} from '../utils/tracking/notifications-tracker';

export default Mixin.create(
	{
		actions: {
			markAsRead(notification) {
				// TODO tracking
				// trackMarkAsRead(notification);
				this.get('notifications').markAsRead(notification);
			}
		}
	}
);

