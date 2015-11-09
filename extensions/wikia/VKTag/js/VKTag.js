(function () {
	'use strict';

	var $ = require('jquery'),
		loader = require('wikia.loader');

	loader({
		type: loader.LIBRARY,
		resources: ['vk']
	}).done(function () {
		$('[data-wikia-widget="vk"]').each(function () {
			var $this = $(this),
				elementId = $this.attr('id'),
				options = $this.data(),
				groupId = options.groupId;

			VK.Widgets.Group(elementId, options, groupId);
		});
	});
})();
