define('ext.wikia.design-system.on-site-notifications.tracking', [
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.common'
	], function (log, common) {
		'use strict';

		function Tracking() {
		}

		Tracking.prototype = {

			markAllAsReadClicked: function () {
				log('clicked - Mark all as read', log.levels.info, common.logTag);
				console.log('clicked - Mark all as read');
			},

			markAsReadClicked: function (uri) {
				log('clicked - Mark as read ' + uri, log.levels.info, common.logTag);
				console.log('clicked - Mark as read ' + uri);
			},

			registerEventHandlers: function (view) {
				view.onMarkAllAsRead.attach(this.markAllAsReadClicked.bind(this));
				view.onMarkAsRead.attach(function (_, uri) {
					this.markAsReadClicked(uri);
				}.bind(this));
			}
		};

		return Tracking
	}
);
