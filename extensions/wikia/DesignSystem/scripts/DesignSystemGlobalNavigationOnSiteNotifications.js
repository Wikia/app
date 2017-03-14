require([
		'jquery',
		'wikia.window',
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.model',
		'ext.wikia.design-system.on-site-notifications.view',
		'ext.wikia.design-system.on-site-notifications.controller'
	], function ($, window, log, Model, View, Controller) {
		'use strict';

		var OnSiteNotifications = {
			init: function () {
				this.view = new View();
				this.model = new Model(this.view);
				this.controller = new Controller(this.model);

				this.view.registerEvents(this.controller);
				this.controller.updateUnreadCount();
			}
		};

		$(function () {
			OnSiteNotifications.init();
		});
	}
);
