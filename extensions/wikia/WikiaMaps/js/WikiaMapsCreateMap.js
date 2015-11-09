(function () {
	'use strict';

	var $ = require('jquery');

	$('#WikiaPage').on('click', '.wikia-maps-create-map', function (e) {
		var loader = require('wikia.loader');

		e.preventDefault();
		loader({
			type: loader.AM_GROUPS,
			resources: 'wikia_maps_create_map_contribute_js'
		}).done(function () {
			var config = require('wikia.maps.config'),
				utils = require('wikia.maps.utils');

			utils.triggerAction(utils.getActionConfig('createMap', config));
			utils.track(utils.trackerActions.CLICK_LINK_BUTTON, 'create-map-clicked', 1);
		});
	});
})();
