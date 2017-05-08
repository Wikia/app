define('ext.wikia.design-system.on-site-notifications.tracking', [
		'jquery',
		'wikia.log',
		'wikia.tracker',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, log, tracker, common) {
		'use strict';

		function Tracking(model) {
			this.model = model;
			this.labels = {
				'discussion-upvote-reply': 'discussion-upvote-reply',
				'discussion-upvote-post': 'discussion-upvote-post',
				'discussion-reply': 'discussion-reply',
				markAllAsRead: 'mark-all-as-read',
				markAsRead: 'mark-as-read',
				openMenu: 'open-menu'
			};
		}

		Tracking.prototype = {

			registerEventHandlers: function (view) {
				view.onMarkAllAsReadClick.attach(this.markAllAsReadClick.bind(this));
				view.onMarkAsReadClick.attach(function (_, id) {
					this.markAsReadClick(id);
				}.bind(this));
				view.onNotificationRender.attach(function (_, id) {
					this.notificationImpression(id);
				}.bind(this));
				view.onNotificationClick.attach(function (_, id) {
					this.notificationClick(id);
				}.bind(this));
				view.onDropDownClick.attach(function (_, event) {
					// when drop down is closed the parent does not have wds-is-active
					var active = $(event.currentTarget).parent('.wds-is-active');
					if (active.length === 0) {
						this.menuOpen();
					}
				}.bind(this));
			},

			menuOpen: function () {
				try {
					log('click - menu-open', log.levels.info, common.logTag);
					this.trackClick(this.labels.openMenu,
						{value: this.model.getUnreadCount()}
					);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			notificationImpression: function (id) {
				try {
					log('impression - notification', log.levels.info, common.logTag);
					var notification = this.findById(id);
					this.trackImpression(this.toLabel(notification.type),
						{value: this.booleanToGa(notification.isUnread)});
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			notificationClick: function (id) {
				try {
					log('click - notification', log.levels.info, common.logTag);
					var notification = this.findById(id);
					this.trackClick(this.toLabel(notification.type),
						{value: this.booleanToGa(notification.isUnread)}
					);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			markAllAsReadClick: function () {
				try {
					log('click - Mark all as read', log.levels.info, common.logTag);
					this.trackClick(this.labels.markAllAsRead);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			markAsReadClick: function (id) {
				try {
					log('click - Mark as read', log.levels.info, common.logTag);
					this.trackClick(this.labels.markAsRead + '-' + this.toLabel(id.type));
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},


			toLabel: function (name) {
				return this.labels[name] || name;
			},

			findById: function (id) {
				return this.model.findById(id);
			},

			trackImpression: function (type, params) {
				this.track(tracker.ACTIONS.IMPRESSION, type, params);
			},

			trackClick: function (type, params) {
				this.track(tracker.ACTIONS.CLICK, type, params);
			},

			track: function (action, type, params) {
				tracker.track(
					this.getTrackingContext(
						type,
						action,
						params
					));
			},

			/**
			 * @param {string} label
			 * @param {string} action
			 * @param {Object} params
			 *
			 * @returns {Object}
			 */
			getTrackingContext: function (label, action, params) {
				return $.extend({
					action: action,
					label: label,
					category: 'on-site-notifications',
					trackingMethod: 'internal'
				}, params);
			},

			booleanToGa: function (boolean) {
				return boolean ? 1 : 0;
			}
		};

		return Tracking
	}
);
