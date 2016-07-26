require(
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.maps.config',
		'wikia.maps.utils',
		'wikia.maps.pontoBridge'
	],
	function ($, qs, w, config, utils, pontoBridge) {
		'use strict';

		var body = $('body'),
			targetIframe =  w.document.getElementsByName('wikia-interactive-map')[0];

		// attach handlers
		body
			.on('change', '#orderMapList', function (event) {
				sortMapList(event.target.value);
			})
			.on('click', 'button#createMap', function () {
				utils.triggerAction(utils.getActionConfig('createMap', config));
				utils.track(utils.trackerActions.CLICK_LINK_BUTTON, 'create-map-clicked', 0);
			})
			.on('click', 'a#deleteMap', function (event) {
				event.preventDefault();
				utils.triggerAction(utils.getActionConfig('deleteMap', config));
			})
			.on('click', '#undeleteMap', function (event) {
				event.preventDefault();
				utils.triggerAction(utils.getActionConfig('undeleteMap', config));
			});

		if (targetIframe) {
			pontoBridge.init(targetIframe);
		}

		/**
		 * @desc reload the page after choosing ordering option
		 * @param {string} sortType - sorting method
		 */
		function sortMapList(sortType) {
			qs().setVal('sort', sortType, false).goTo();
		}

		// VE Insert Map dialog passes this hash to initiate map creating process right away
		if (w.location.hash === '#createMap') {
			utils.triggerAction(utils.getActionConfig('createMap', config));
		}
	}
);
