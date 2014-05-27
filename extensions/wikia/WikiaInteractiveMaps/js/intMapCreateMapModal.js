define(
	'wikia.intMaps.createMap.modal',
	[
		'jquery',
		'wikia.intMap.createMap.utils',
		'wikia.intMap.createMap.tileSet',
		'wikia.intMap.createMap.preview'
	],
	function($, utils, tileSet, preview) {
		'use strict';

		// placeholder for holding reference to modal instance
		var modal,
			// modal configuration
			modalConfig = {
				vars: {
					id: 'intMapCreateMapModal',
					classes: ['intMapCreateMapModal'],
					size: 'medium',
					content: '',
					title: $.msg('wikia-interactive-maps-create-map-header'),
					buttons: [
						{
							vars: {
								value: $.msg('wikia-interactive-maps-create-map-next-btn'),
								classes: ['normal', 'primary'],
								id: 'intMapNext'
							}
						},
						{
							vars: {
								value:  $.msg('wikia-interactive-maps-create-map-back-btn'),
								id: 'intMapBack'
							}
						}
					]
				}
			},
			events = {
				error: [
					function(message) {
						showError(message);
					}
				],
				cleanUpError: [
					cleanUpError
				],
				mapCreated: [
					function(data) {
						showCreatedMap(data);
					}
				]
			};

		/**
		 * @desc Entry point for create map modal
		 * @param {array} templates - mustache templates
		 */

		function init(templates) {
			modalConfig.vars.content = utils.render(templates[0], {});

			createModal(modalConfig, function() {
				modal.$buttons = modal.$element.find('.buttons').children();
				modal.$innerContent = modal.$content.children('#intMapInnerContent');
				modal.$errorContainer = $('.map-creation-error');

				utils.bindEvents(modal, events);

				// init modal steps
				tileSet.init(modal, templates[1]);
				preview.init(modal, templates[2]);

				modal.trigger('chooseTileSet');
				modal.show();
			});
		}

		/**
		 * @desc creates modal component
		 * @param {object} config - modal config
		 * @param {function} cb - callback function called after creating modal
		 */

		function createModal(config, cb) {
			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(function (uiModal) {
					uiModal.createComponent(config, function (component) {
						// set reference to modal component
						modal = component;
						cb();
					});
				});
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
			qs(data.mapUrl).goTo();
		}

		return {
			init: init
		};
	}
);
