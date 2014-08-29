require(
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.intMap.config',
		'wikia.intMap.utils',
		'wikia.intMap.pontoBridge',
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
				utils.triggerAction(config, 'createMap');
			})
			.on('click', 'a#deleteMap', function (event) {
				event.preventDefault();
				utils.triggerAction(config, 'deleteMap');
			})
			.on('click', '#unDeleteMap', function (event) {
				event.preventDefault();
				utils.triggerAction(config, 'unDeleteMap');
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
			utils.triggerAction(config, 'createMap');
		}
	}
);
