define('ext.wikia.design-system.loading-spinner', [
	'jquery',
	'ext.wikia.design-system.templating',
], function ($, templating) {
	'use strict';

	var templateLocation = '';

	function LoadingSpinner(size) {



		this.render = function () {
			return templating.renderByLocation(templateLocation)
		}
	}

	return {
		create: LoadingSpinner
	}
});
