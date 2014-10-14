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
		articleInputId = '#intMapArticleTitle',
		poiModalModes = {
			CREATE: 'create',
			EDIT: 'edit'
		},
		poiModalMode,
		suggestionsVisible = false,
		suggestionSelectedClass = 'selected',
		arrowHandlers,
		direction = {
			up: 1,
			down: -1
		};

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
			modal.$articleImageUrl = modal.$form.find('.article-image-url');
			modal.$articleImagePlaceholder = modal.$form.find('#intMapArticleImagePlaceholder');
			if (modal.$articleImageUrl.attr('src')) {
				// Remove placeholder image if article has image
				modal.$articleImagePlaceholder.hide();
			}

			utils.bindEvents(modal, events);

			// TODO: figure out if there is better place for article suggestions event bindings
			modal.$element
				.on('keyup', articleInputId, $.debounce(utils.constants.debounceDelay, suggestArticles))
				.on('click', onClickOutsideSuggestions);

			modal.show();
		});

		// Setup suggestion key handlers
		arrowHandlers = {
			// Enter key
			13: handleSuggestionsEnter,
			// Esc key
			27: function() {
				hideSuggestions();
			},
			// Arrow up
			38: function() {
				handleSuggestionsArrow(direction.up);
			},
			// Arrow down
			40: function() {
				handleSuggestionsArrow(direction.down);
			}
		};

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
	 * @desc Scrolls $container to position $element on the top
	 * @param {object} $container
	 * @param {object} $element
	 */
	function scrollToElement($container, $element) {
		$container.scrollTop($container.scrollTop() + $element.position().top);
	}

	/**
	 * @desc Handle Enter key on suggest
	 */
	function handleSuggestionsEnter() {
		modal.$suggestions.find('.' + suggestionSelectedClass).find('a').click();
	}

	/**
	 * @desc Handle Arrow keys on suggest
	 *
	 * @param {number} arrowDirection - Value defined in the direction object
	 */
	function handleSuggestionsArrow(arrowDirection) {
		var $selected = modal.$suggestions.find('.' + suggestionSelectedClass),
			isDownArrow = arrowDirection === direction.down,
			selector = isDownArrow ? ':first' : ':last',
			$next;
		if ($selected.length) {
			// go to next selected
			$next = isDownArrow ? $selected.next() : $selected.prev();

			if ($next.length) {
				$selected.removeClass(suggestionSelectedClass);
				$next.addClass(suggestionSelectedClass);
				scrollToElement(modal.$suggestions, $next);
			}
		} else {
			modal.$suggestions.children(selector).addClass(suggestionSelectedClass);
		}
	}

	/**
	 * @desc Handle control keys on suggestion
	 * @param {number} keyCode
	 * @returns {boolean} true if handled
	 */
	function processSuggestKeyEvents(keyCode) {
		if (suggestionsVisible && arrowHandlers.hasOwnProperty(keyCode)) {
			arrowHandlers[keyCode]();
			return true;
		}
		return false;
	}

	/**
	 * @desc handler for article suggestions
	 * @param {Event} event
	 */
	function suggestArticles(event) {
		removeImagePreview();

		if (!processSuggestKeyEvents(event.keyCode)) {
			utils.onWriteInInput(
				event.target,
				function (inputValue) {
					getSuggestions(inputValue, showSuggestions);
				}
			);
		}
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
			callback: function (response) {
				cb(response.results);
			},
			onErrorCallback: hideSuggestions
		});
	}

	/**
	 * @desc renders suggestions list and show it
	 * @param {object} suggestions - object with suggestions items {items: [] }
	 */
	function showSuggestions(suggestions) {
		suggestionsVisible = true;
		modal.$suggestions
			.html(utils.render(articleSuggestionTemplate, suggestions))
			.removeClass('hidden');
	}

	/**
	 * @desc hide suggestions list
	 */
	function hideSuggestions() {
		suggestionsVisible = false;
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

		if (dataSet.imageUrl) {
			addImagePreview(dataSet.imageUrl);
		} else {
			removeImagePreview();
		}

		hideSuggestions();
	}

	/**
	 * @desc adds article image preview
	 * @param {string} imageUrl - url for the image
	 */
	function addImagePreview(imageUrl) {
		modal.$articleImageUrl
			.attr('src', imageUrl)
			.removeClass('hidden');

		modal.$articleImagePlaceholder.hide();

		modal.$form.find('input[name=imageUrl]').val(imageUrl);
	}

	/**
	 * @desc clears article image preview
	 */
	function removeImagePreview() {
		modal.$articleImagePlaceholder.show();

		modal.$articleImageUrl
			.addClass('hidden')
			.attr('src', '');

		modal.$form.find('input[name=imageUrl]').val('');
	}

	/**
	 * @desc special handler for closing article suggestion
	 * @param {Event} event
	 */
	function onClickOutsideSuggestions(event) {
		var $target = $(event.target);

		if (!$target.hasClass('article-suggestion') && !$target.is(articleInputId)) {
			hideSuggestions();
		}
	}

	/**
	 * @desc encodes HTML entities in POI data
	 * @param {object} poiData
	 */
	function encodePOIData(poiData) {
		poiData.name = utils.escapeHtml(poiData.name);
		poiData.description = poiData.description ? utils.escapeHtml(poiData.description) : '';
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

					encodePOIData(poiData);
					trigger(poiData);

					modal.activate();
					modal.trigger('close');
					trackPoiAction(poiData);
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

	/**
	 * @desc Sends to GA information about adding/editing a POI
	 *
	 * @param {object} poiData
	 */
	function trackPoiAction(poiData) {
		var poiId = poiData.id,
			gaLabel = 'poi-' + poiModalMode,
			gaValue = poiId || mapId;

		utils.track(utils.trackerActions.IMPRESSION, gaLabel, gaValue);
	}

	return {
		init: init
	};
});
