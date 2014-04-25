require(['jquery', 'wikia.mustache'], function ($, mustache) {
	'use strict';

	/**
	 * @desc Shows a modal with map inside
	 *
	 * @param {Object} $target - map thumbnail jQuery object that gives context to which map should be shown
	 */
	function showMap($target) {
		var $anchor = $($target.parent()),
			tagParams = getDataParams($anchor),
			templatePath = '',
			iframe = '';

		// just because the path is to long JSHint shows an error here, should we ignore it and keep it in one line?
		templatePath += 'extensions/wikia/WikiaInteractiveMaps/templates/';
		templatePath += 'WikiaInteractiveMapsController_mapIframe.mustache';

		loadTemplate(templatePath).done(function (template) {
			iframe = mustache.render(template, {
				url: tagParams['map-url']
			});
		});

		require(['wikia.ui.factory'], function (uiFactory) {
			uiFactory.init(['modal']).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'interactiveMap-' + tagParams['map-id'],
						size: 'large',
						content: iframe
					}
				};

				uiModal.createComponent(modalConfig, function (mapModal) {
					mapModal.show();
				});
			});
		});
	}

	/**
	 * @desc Creates an object with data from data-* parameters of a jQuery wrapper on DOM element
	 *
	 * @param $el jQuery wrapped DOM element from which the data will be extracted
	 * @returns {Object} with map-id, lat, lon and zoom parameters
	 */
	function getDataParams($el) {
		var result = {
			'map-id': null,
			'map-url': null,
			'lat': null,
			'lon': null,
			'zoom': null
		},
			paramName;

		for (paramName in result) {
			result[paramName] = $el.data(paramName);
		}

		return result;
	}

	/**
	 * @desc Loads the template with wikia.loader module and returns promise
	 *
	 * @param {String} templatePath path to the template
	 * @returns {*} promise
	 */
	function loadTemplate(templatePath) {
		var dfd = new $.Deferred();

		require(['wikia.loader'], function (loader) {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: templatePath
				}
			}).done(function (data) {
				// data.mustache[0] is the mustache template loaded by wikia.loader
				dfd.resolve(data.mustache[0]);
			});
		});

		return dfd.promise();
	}

	/** Attach events */
	$('body').on('click', '.wikia-interactive-map-thumbnail img', function (event) {
		event.preventDefault();
		showMap($(event.target));
	});

});
