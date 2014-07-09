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
			selectArticle: [
				selectArticle
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
		articleSuggestionTemplate,
		articleInputId = '#intMapArticleTitle';

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

		// cache article suggestion template
		articleSuggestionTemplate = templates[1];

		mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

		setModalMode(params.hasOwnProperty('id'));

		modalConfig.vars.content = utils.render(templates[0], extendTemplateData(templateData, params));

		utils.createModal(modalConfig, function (_modal) {
			// set reference to modal component
			modal = _modal;

			// cache selectors
			modal.$errorContainer = modal.$content.children('.error');
			modal.$form = $('#intMapEditPOIForm');
			modal.$suggestions = $('#intMapArticleSuggestions');
			modal.$articleTitle = $(articleInputId);
			modal.$articleImageUrl = modal.$form.find('.articleImageUrl');

			utils.bindEvents(modal, events);

			// TODO: figure out if there is better place for article suggestions event bindings
			modal.$element
				.on('keyup', articleInputId, $.debounce(utils.constants.debounceDelay, suggestArticles))
				.on('click', onClickOutsideSuggestions);

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

		if (isEditMode) {
			title = editPOITitle;
			buttons.push(deletePOIButton);
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
	 * @desc handler for article suggestions
	 * @param {Event} event
	 */
	function suggestArticles(event) {
		utils.onWriteInInput(event.target, function(inputValue) {
			getSuggestions(inputValue, function(suggestions) {
				showSuggestions(suggestions);
			});
		});
	}

	/**
	 * @desc gets article suggestions from backend
	 * @param {string} keyword - search term
	 * @param {function} cb - callback function
	 */
	function getSuggestions(keyword, cb) {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsPoi',
			method: 'getSuggestedArticles',
			type: 'GET',
			data: {
				query: keyword
			},
			callback: function(response) {
				cb(response.results);
			},
			onErrorCallback: function() {
				hideSuggestions();
			}
		});
	}

	/**
	 * @desc renders suggestions list and show it
	 * @param {object} suggestions - object with suggestions items {items: [] }
	 */
	function showSuggestions(suggestions) {
		modal.$suggestions
			.html(utils.render(articleSuggestionTemplate, suggestions))
			.removeClass('hidden');
	}

	/**
	 * @desc hide suggestions list
	 */
	function hideSuggestions() {
		modal.$suggestions
			.html('')
			.addClass('hidden');
	}

	/**
	 * @desc handler for selecting article
	 * @param {Event} event
	 */
	function selectArticle(event) {
		var dataSet = event.target.dataset;

		modal.$articleTitle
			.val(dataSet.title)
			.blur();

		if( dataSet.imageUrl ) {
			modal.$articleImageUrl.attr('src', dataSet.imageUrl);
			modal.$form.find('input[name=imageUrl]').val(dataSet.imageUrl);
		} else {
			modal.$articleImageUrl.attr('src', '');
			modal.$form.find('input[name=imageUrl]').val('');
		}

		hideSuggestions();
	}

	/**
	 * @desc special handler for closing article suggestion
	 * @param {Event} event
	 */
	function onClickOutsideSuggestions(event) {
		var $target = $(event.target);

		if (!$target.hasClass('article-suggestion') && !$target.is(articleInputId) ) {
			hideSuggestions();
		}
	}

	/**
	 * @desc sends request to backend with POI data
	 * @param {object} poiData - POI data
	 */
	function sendData(poiData) {
		if (!poiData) {
			return;
		}

		modal.deactivate();

		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsPoi',
			method: 'editPoi',
			type: 'POST',
			data: poiData,
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					poiData.id = data.content.id;
					poiData.link = data.content.link;
					poiData.photo = data.content.photo;

					trigger(poiData);

					modal.activate();
					modal.trigger('close');
				} else {
					utils.showError(modal, data.content.message);
					modal.activate();
				}
			},
			onErrorCallback: function(response) {
				utils.handleNirvanaException(modal, response);
				modal.activate();
			}
		});
	}

	return {
		init: init
	};
});
