require([
		'jquery',
		'ext.wikia.design-system.on-site-notifications.model',
		'ext.wikia.design-system.on-site-notifications.view',
		'ext.wikia.design-system.on-site-notifications.controller'
	], function ($, Model, View, Controller) {
		'use strict';

		var OnSiteNotifications = {
			init: function () {
				this.view = new View();
				this.model = new Model();
				this.controller = new Controller(this.model);

				this.view.registerEvents(this.controller, this.model);
				this.controller.updateUnreadCount();
			}
		};

		$(function () {
			OnSiteNotifications.init();
		});
	}
);
