define('wikia.intMap.editPOI', ['jquery', 'wikia.intMap.utils'], function($, utils) {
	'use strict';

	// placeholder for holding reference to modal instance
	var modal,
	// modal configuration
		modalConfig = {
			vars: {
				id: 'intMapEditPOI',
				classes: ['intMapEditPOI', 'intMapModal'],
				size: 'medium',
				content: '',
				title: $.msg('wikia-interactive-maps-edit-poi-header'),
				buttons: [{
					vars: {
						value: $.msg('wikia-interactive-maps-edit-poi-save'),
						classes: ['normal', 'primary'],
						data: {
							key: 'event',
							value: 'save'
						}
					}
				}, {
					vars: {
						value: $.msg('wikia-interactive-maps-edit-poi-cancel'),
						data: {
							key: 'event',
							value: 'close'
						}
					}
				}
//				{
//					vars: {
//						value: $.msg('wikia-interactive-maps-edit-poi-delete'),
//						data: {
//							key: 'event',
//							value: 'delete'
//						}
//					}
//				}
				]
			}
		},
		events = {
			save: [
				save
			],
			beforeClose: [
				utils.refreshIfAfterForceLogin
			]
		},
		templateData = {
			namePlaceholder: $.msg('wikia-interactive-maps-edit-poi-name-placeholder'),
			articlePlaceholder:  $.msg('wikia-interactive-maps-edit-poi-article-placeholder'),
			descriptionPlaceholder: $.msg('wikia-interactive-maps-edit-poi-description-placeholder'),
			categoryPlaceholder: $.msg('wikia-interactive-maps-edit-poi-category-placeholder'),
			categories: []
		},
		trigger;

	/**
	 * @desc Entry point for  modal
	 * @param {array} templates - mustache templates
	 * @param {object} params - params from iframe (ponto)
	 * @param {function} _trigger - callback function to send result back to iframe (ponto)
	 */
	function init(templates, params, _trigger) {
		// set reference to trigger callback
		trigger = _trigger;

		// extend template data with params sent from iframe
		$.extend(templateData, params);

		modalConfig.vars.content = utils.render(templates[0], templateData);
		utils.createModal(modalConfig, function (_modal) {
			// set reference to modal component
			modal = _modal;

			// cache selectors
			modal.$errorContainer = modal.$content.children('.error');
			modal.$form = $('#intMapEditPOIForm');

			utils.bindEvents(modal, events);
			modal.show();
		});
	}

	/**
	 * @desc shows error message
	 * @param {string} error - error message
	 * @todo this could be abstracted in future
	 */
	function showError(error) {
		modal.$errorContainer
			.html(error)
			.removeClass('hidden');
	}

	/**
	 * @desc calls function chain used to save POI
	 */
	function save() {
		sendData(validatePOIData(utils.serializeForm(modal.$form)));
	}

	/**
	 * @desc validates form data
	 * @param {object} data - serialized form data
	 */
	function validatePOIData(data) {
		var required = ['name', 'pinTypeId'],
			valid = required.every(function(value) {
				if (utils.isEmpty(data[value])) {
					showError($.msg('wikia-interactive-maps-edit-poi-error-' + utils.camelCaseToDash(value)));
					return false;
				}
				return true;
			});

		return (valid ? data : false);
	}

	/**
	 * @desc sends request to backend with POI data
	 * @param {object} data - POI data
	 */
	function sendData(data) {
		if (!data) {
			return;
		}

		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsPoi',
			method: 'editPoi',
			type: 'POST',
			data: data,
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					trigger(data.content);
					modal.trigger('close');
				} else {
					showError(data.content.message);
				}
			},
			onErrorCallback: function(errResponse) {
				showError(errResponse.results.content.message);
			}
		});
	}

	return {
		init: init
	};
});