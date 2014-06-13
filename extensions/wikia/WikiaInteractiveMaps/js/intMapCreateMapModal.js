define(
	'wikia.intMaps.createMap.modal', [
		'jquery',
		'wikia.window',
		'wikia.intMap.utils',
		'wikia.intMap.createMap.tileSet',
		'wikia.intMap.createMap.preview',
		'wikia.intMap.createMap.pinTypes'
	],
	function($, w, utils, tileSet, preview, pinTypes) {
		'use strict';

		// placeholder for holding reference to modal instance
		var modal,
			// modal configuration
			modalConfig = {
				vars: {
					id: 'intMapCreateMapModal',
					classes: ['intMapCreateMapModal', 'intMapModal'],
					size: 'medium',
					content: '',
					title: $.msg('wikia-interactive-maps-create-map-header'),
					buttons: [{
						vars: {
							value: $.msg('wikia-interactive-maps-create-map-next-btn'),
							classes: ['normal', 'primary'],
							id: 'intMapNext'
						}
					}, {
						vars: {
							value: $.msg('wikia-interactive-maps-create-map-back-btn'),
							id: 'intMapBack'
						}
					}]
				}
			},
			events = {
				error: [
					function (message) {
						showError(message);
					}
				],
				cleanUpError: [
					cleanUpError
				],
				beforeClose: [
					utils.refreshIfAfterForceLogin
				]
			};

		/**
		 * @desc Entry point for create map modal
		 * @param {array} templates - mustache templates
		 */

		function init(templates) {
			modalConfig.vars.content = utils.render(templates[0], {});

			utils.createModal(modalConfig, function (_modal) {
				// set reference to modal component
				modal = _modal;

				modal.$buttons = modal.$element.find('.buttons').children();
				modal.$innerContent = modal.$content.children('#intMapInnerContent');
				modal.$errorContainer = $('.map-creation-error');

				utils.bindEvents(modal, events);

				// init modal steps
				// TODO: figure out the way to automatically register and init different step of the UI
				tileSet.init(modal, templates[1],  templates[2]);
				preview.init(modal, templates[3]);
				pinTypes.init(modal, templates[4], templates[5]);

				modal.trigger('chooseTileSet');
				modal.show();
			});
		}

		/**
		 * @desc displays error message
		 * @param {string} message - error message
		 */

		function showError(message) {
			modal.$errorContainer
				.html(message)
				.removeClass('hidden');
		}

		/**
		 * @desc cleans up error message and hides error container
		 */

		function cleanUpError() {
			modal.$errorContainer
				.html('')
				.addClass('hidden');
		}

		/**
		 * @desc redirects to the map page
		 * @param {object} data - map data
		 */

		//TODO: to be changed when pin types step will be added
		function showCreatedMap(data) {
			qs(data.content.mapUrl).goTo();
		}

		return {
			init: init
		};
	}
);

