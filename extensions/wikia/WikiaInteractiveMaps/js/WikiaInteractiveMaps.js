require(['jquery', 'wikia.mustache'], function ($, mustache) {
	'use strict';

	/**
	 * @desc Shows a modal with map inside
	 *
	 * @param {Object} $target - map thumbnail jQuery object that gives context to which map should be shown
	 */
	function showMap($target) {
		var tagParams = getDataParams($target),
			templatePath = 'extensions/wikia/WikiaInteractiveMaps/templates/' +
				'WikiaInteractiveMapsController_mapIframe.mustache',
			cacheKey = 'wikia-interactive-maps-map-iframe',
			iframe = '';

		loadTemplate(templatePath, cacheKey).done(function (template) {
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
	 * @desc Checks if template is cached in LocalStorage and if not loads it by using loader
	 *
	 * @todo Talk to Platform Team about making it global, so other teams can re-use it
	 *
	 * @param {String} templatePath path to the template
	 * @returns {$.Deferred}
	 */
	function loadTemplate(templatePath, cacheKey) {
		var dfd = new $.Deferred();

		require(['wikia.loader', 'wikia.cache'], function (loader, cache) {
			var template = cache.getVersioned(cacheKey);

			if (template) {
				dfd.resolve(template);
			} else {
				loader({
					type: loader.MULTI,
					resources: {
						mustache: templatePath
					}
				}).done(function (data) {
					template = data.mustache[0];

					dfd.resolve(template);

					cache.setVersioned(cacheKey, template, 604800); //7days
				});
			}

		});

		return dfd.promise();
	}

	/** Attach events */
	$('body').on('click', '.wikia-interactive-map-thumbnail', function (event) {
		event.preventDefault();
		showMap($(event.currentTarget));
	});

});
