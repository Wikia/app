define('wikia.intMap.editPOI', ['jquery', 'wikia.intMap.utils'], function($, utils) {
	'use strict';

	// placeholder for holding reference to modal instance
	var modal,
		// modal configuration
		modalConfig = {
			vars: {
				id: 'intMapEditPOI',
				classes: ['int-map-modal'],
				size: 'medium',
				content: '',
				title: '',
				buttons: []
			}
		},
		events = {
			save: [
				save
			],
			deletePOI: [
				deletePOI
			],
			beforeClose: [
				utils.refreshIfAfterForceLogin
			]
		},
		templateData = {
			namePlaceholder: $.msg('wikia-interactive-maps-edit-poi-name-placeholder'),
			articlePlaceholder:  $.msg('wikia-interactive-maps-edit-poi-article-placeholder'),
			descriptionPlaceholder: $.msg('wikia-interactive-maps-edit-poi-description-placeholder'),
			categoryPlaceholder: $.msg('wikia-interactive-maps-edit-poi-category-placeholder')
		},
		addPOITitle = $.msg('wikia-interactive-maps-edit-poi-header-add-poi'),
		editPOITitle = $.msg('wikia-interactive-maps-edit-poi-header-edit-poi'),
		modalButtons = [
			{
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
		],
		deletePOIButton = {
			vars: {
				value: $.msg('wikia-interactive-maps-edit-poi-delete'),
				data: {
					key: 'event',
					value: 'deletePOI'
				}
			}
		},
		trigger,
		params,
		mapId,
		poiModalModes = {
			CREATE: 'create',
			EDIT: 'edit'
		},
		poiModalMode;

	/**
	 * @desc Entry point for  modal
	 * @param {array} templates - mustache templates
	 * @param {object} _params - params from iframe (ponto)
	 * @param {function} _trigger - callback function to send result back to iframe (ponto)
	 */
	function init(templates, _params, _trigger) {
		// set reference to params and trigger callback
		trigger = _trigger;
		params = _params;
		mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

		setModalMode(params.hasOwnProperty('id'));

		modalConfig.vars.content = utils.render(templates[0], extendTemplateData(templateData, params));

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
	 * @desc sets modal mode (add new POI / edit existing POI)
	 * @param {bool} isEditMode
	 */
	function setModalMode(isEditMode) {
		var title = addPOITitle,
			buttons = [].concat(modalButtons);

		poiModalMode = poiModalModes.CREATE;
		if (isEditMode) {
			title = editPOITitle;
			buttons.push(deletePOIButton);
			poiModalMode = poiModalModes.EDIT;
		}

		modalConfig.vars.title = title;
		modalConfig.vars.buttons = buttons;
	}

	/**
	 * @desc extends template data
	 * @param {object} templateData - mustache template data
	 * @param {object} params - point data from iframe Ponto
	 * @returns {object} extended template data
	 */
	function extendTemplateData(templateData, params) {
		// set current POI category (for edit action)
		Object.keys(params.categories).forEach(function(key) {
			if (params.categories[key].id === parseInt(params.poi_category_id, 10)) {
				params.categories[key].selected = true;
			}
		});

		return $.extend({}, templateData, params);
	}

	/**
	 * @desc calls function chain used to save POI
	 */
	function save() {
		sendData(validatePOIData(utils.serializeForm(modal.$form)));
	}

	/**
	 * @desc deletes POI
	 */

	function deletePOI() {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsPoi',
			method: 'deletePoi',
			type: 'POST',
			data: {
				id: params.id,
				mapId: mapId
			},
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					trigger(false);
					modal.trigger('close');
				} else {
					utils.showError(modal, data.content.message);
				}
			},
			onErrorCallback: function(response) {
				utils.handleNirvanaException(modal, response);
			}
		});
	}

	/**
	 * @desc validates form data
	 * @param {object} data - serialized form data
	 */
	function validatePOIData(data) {
		var required = ['name', 'poi_category_id'],
			valid = required.every(function(value) {
				if (utils.isEmpty(data[value])) {
					utils.showError(modal, $.msg('wikia-interactive-maps-edit-poi-error-' + value.replace(/_/g, '-')));
					return false;
				}
				return true;
			});

		return (valid ? data : false);
	}

	/**
	 * @desc sends request to backend with POI data
	 * @param {object} poiData - POI data
	 */
	function sendData(poiData) {
		if (!poiData) {
			return;
		}

		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsPoi',
			method: 'editPoi',
			type: 'POST',
			data: poiData,
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					poiData.id = data.content.id;
					trigger(poiData);
					modal.trigger('close');
					trackPoiAction(poiData);
				} else {
					utils.showError(modal, data.content.message);
				}
			},
			onErrorCallback: function(response) {
				utils.handleNirvanaException(modal, response);
			}
		});
	}

	/**
	 * @desc Sends to GA information about adding/editing a POI
	 *
	 * @param {object} poiData
	 */
	function trackPoiAction(poiData) {
		var gaLabel, gaValue;

		switch(poiModalMode) {
			case poiModalModes.CREATE:
				gaLabel = 'poi-created';
				gaValue = mapId;
				break;
			case poiModalModes.EDIT:
				gaLabel = 'poi-edited';
				gaValue = poiData.id;
				break;
		}

		utils.track(utils.trackerActions.IMPRESSION, gaLabel, gaValue);
	}

	return {
		init: init
	};
});
