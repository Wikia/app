define('ext.wikia.design-system.templating', [
	'wikia.mustache',
	'ext.wikia.design-system.templates.mustache'
], function (mustache, templates) {
	'use strict';

	function renderNotifications(params) {
		return mustache.render(templates['DesignSystemGlobalNavigationOnSiteNotifications'], params);
	}

	function renderSpinner(params) {
		return mustache.render(templates['DesignSystemLoadingSpinner'], params);
	}

	return {
		renderNotifications: renderNotifications,
		renderSpinner: renderSpinner
	}
});
