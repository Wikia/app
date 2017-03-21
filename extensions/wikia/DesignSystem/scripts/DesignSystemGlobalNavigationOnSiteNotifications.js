require([
		'jquery',
		'ext.wikia.design-system.on-site-notifications.model',
		'ext.wikia.design-system.on-site-notifications.view',
		'ext.wikia.design-system.on-site-notifications.controller',
		'ext.wikia.design-system.on-site-notifications.tracking'
	], function ($, Model, View, Controller, Tracking) {
		'use strict';

		var OnSiteNotifications = {
			init: function () {
				this.view = new View();
				this.model = new Model();
				this.controller = new Controller(this.model);
				this.tracking = new Tracking(this.model);

				this.view.registerEventHandlers(this.model);
				this.controller.registerEventHandlers(this.view);
				this.tracking.registerEventHandlers(this.view);
				this.controller.updateUnreadCount();
			}
		};

		$(function () {
			OnSiteNotifications.init();
		});
	}
);
