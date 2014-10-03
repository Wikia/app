require(['jquery', 'wikia.loader'], function ($, loader) {
	'use strict';

	$('#WikiaPage').on('click', '.wikia-maps-create-map', function (e) {
		e.preventDefault();
		loader({
			type: loader.AM_GROUPS,
			resources: 'wikia_maps_create_map_contribute_js'
		}).done(function () {
			require(['wikia.maps.config', 'wikia.maps.utils'], function (config, utils) {
				utils.triggerAction(utils.getActionConfig('createMap', config));
				utils.track(utils.trackerActions.CLICK_LINK_BUTTON, 'create-map-clicked', 1);
			});
		});
	});
});
