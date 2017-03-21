define('ext.wikia.design-system.on-site-notifications.tracking', [
		'jquery',
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, log, common) {
		'use strict';

		function Tracking(model) {
			this.model = model;
			this.gaCategory = 'on-site-notifications';
			this.labels = {
				'discussion-upvote-reply': 'discussion-upvote-reply',
				'discussion-upvote-post': 'discussion-upvote-post',
				'discussion-reply': 'discussion-reply',
				'mark-all-as-read': 'mark-all-as-read',
				'mark-as-read': 'mark-as-read',
				'open-menu': 'open-menu'
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
			},

			notificationImpression: function (id) {
				try {
					log('impression - notification', log.levels.info, common.logTag);
					var notification = this.findById(id);
					this.trackImpression(this.labels[notification.type],
						{value: this.booleanToGa(notification.isUnread)});
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			notificationClick: function (id) {
				try {
					log('click - notification', log.levels.info, common.logTag);
					var notification = this.findById(id);
					this.trackClick(this.labels[notification.type],
						{value: this.booleanToGa(notification.isUnread)}
					);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			markAllAsReadClick: function () {
				try {
					log('click - Mark all as read', log.levels.info, common.logTag);
					this.trackClick(this.labels['mark-all-as-read']);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
				}
			},

			markAsReadClick: function (id) {
				try {
					log('click - Mark as read', log.levels.info, common.logTag);
					this.trackClick(this.labels['mark-as-read'] + '-' + this.labels[id.type]);
				} catch (e) {
					log(e, log.levels.error, common.logTag);
					console.log(e);
				}
			},

			findById: function (id) {
				return this.model.findById(id);
			},

			trackImpression: function (type, params) {
				this.track('impression', type, params);
			},

			trackClick: function (type, params) {
				this.track('click', type, params);
			},

			track: function (action, type, params) {
				this.doTrack(
					this.getTrackingContext(
						type,
						action,
						params
					));
			},

			doTrack: function (params) {
				console.log(params);
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
					category: this.gaCategory,
					label: label
				}, params);
			},

			booleanToGa: function (boolean) {
				return boolean ? 1 : 0;
			}
		};

		return Tracking
	}
);
