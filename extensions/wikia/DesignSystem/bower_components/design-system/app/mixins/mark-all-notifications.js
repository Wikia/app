import Mixin from '@ember/object/mixin';
// import {trackMarkAllAsRead} from '../utils/tracking/notifications-tracker';

export default Mixin.create(
	{
		actions: {
			markAllAsRead() {
				// TODO tracking
				// trackMarkAllAsRead();
				this.get('notifications').markAllAsRead();
			}
		}
	}
);
