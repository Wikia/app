define(
	'wikia.maps.createMap.modal', [
		'jquery',
		'wikia.window',
		'wikia.maps.utils',
		'wikia.maps.createMap.tileSet',
		'wikia.maps.createMap.preview'
	],
	function ($, w, utils, tileSet, preview) {
		'use strict';

		// placeholder for holding reference to modal instance
		var modal,
			// modal configuration
			modalConfig = {
				vars: {
					id: 'intMapCreateMapModal',
					classes: ['int-map-modal'],
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
						utils.showError(modal, message);
					}
				],
				cleanUpError: [
					function () {
						utils.cleanUpError(modal);
					}
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
				modal.$errorContainer = $('.map-modal-error');
				$(modal.$element).on('submit', '.create-map-form', function (event) {
					event.preventDefault();
					modal.trigger('createMap');
				});

				utils.bindEvents(modal, events);

				// init modal steps
				// TODO: figure out the way to automatically register and init different step of the UI
				tileSet.init(modal, templates[1],  templates[2]);
				preview.init(modal, templates[3]);

				modal.trigger('chooseTileSet');
				modal.show();
			});
		}

		return {
			init: init
		};
	}
);
