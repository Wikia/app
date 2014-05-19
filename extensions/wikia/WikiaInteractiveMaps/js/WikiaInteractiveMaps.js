require(['wikia.querystring', 'jquery', 'wikia.window', 'wikia.mustache'], function (qs, $, w, mustache) {
	'use strict';

	var doc = w.document,
		body = doc.getElementsByTagName('body')[0],
		orderingOptions = doc.getElementById('orderMapList'),

		templates = {},
		templatesData = {
			mapType: {
				types: [
					{
						title: $.msg('wikia-interactive-maps-create-map-choose-type-geo'),
						type: 'geo'
					},
					{
						title: $.msg('wikia-interactive-maps-create-map-choose-type-custom'),
						type: 'custom'

					}
				]
			}
		};

	// attach handlers
	orderingOptions.addEventListener('change', function(event) {
		sortMapList(event.target.value);
	});

	body.addEventListener('click', function(event) {
		if (event.target.id === 'createMap') {
			createMap();
		}
	});

	body.addEventListener('click', function(event) {
		if (event.target.id === 'intMap-custom') {
			changeStep()
		}
	});


	/**
	 @desc reload the page after choosing ordering option
	 @param {string} sortType - sorting method
	 */

	function sortMapList(sortType) {
		qs().setVal('sort', sortType, false).goTo();
	}


	function createMap() {
		require(['wikia.ui.factory'], function (uiFactory) {
			$.when(
				uiFactory.init(['modal']),
				loadTemplates()
			).done(function (uiModal, templates) {
				var modalConfig = {
						vars: {
							id: 'intMapCreate',
							size: 'medium',
							content: mustache.render(templates[0], templatesData.mapType),
							title: $.msg('wikia-interactive-maps-create-map')
						}
					};

				uiModal.createComponent(modalConfig, function (mapModal) {
					mapModal.show();
				});
			});
		});
	}

	/**
	 * @desc load templates for create maps modal
	 */
	function loadTemplates() {
		var dfd = new $.Deferred();

		require(['wikia.loader', 'wikia.cache'], function (loader, cache) {
			// TODO: add caching for templates
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/WikiaInteractiveMaps/templates/WikiaInteractiveMapsController_createMap_chooseType.mustache,' +
						'extensions/wikia/WikiaInteractiveMaps/templates/WikiaInteractiveMapsController_createMap_chooseTileSetType.mustache'
				}
			}).done(function (data) {
				dfd.resolve(data.mustache);
			});
		});

		return dfd;
	}

	function chooseTileSetType(modal) {
		modal.setContent()
	}

	function renderTileSetStep(template) {
		return mustache.render(template, {});
	}
});

//buttons: [
//								{
//									vars: {
//										value: $.msg('wikia-interactive-maps-create-map-next-btn'),
//										classes: ['normal', 'primary'],
//										data: [
//											{
//												key: 'event',
//												value: 'next'
//											}
//										]
//									}
//								},
//								{
//									vars: {
//										value: $.msg('wikia-interactive-maps-create-map-back-btn'),
//										data: [
//											{
//												key: 'event',
//												value: 'back'
//											}
//										]
//									}
//								}
//							]

