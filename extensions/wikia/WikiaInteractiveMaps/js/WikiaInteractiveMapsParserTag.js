require(['jquery', 'wikia.mustache', 'wikia.tracker'], function ($, mustache, tracker) {
	'use strict';

	/**
	 * @desc Checks if template is cached in LocalStorage and if not loads it by using loader
	 *
	 * @todo Talk to Platform Team about making it global, so other teams can re-use it
	 *
	 * @param {String} templatePath path to the template
	 * @param {String} cacheKey the key in local storage
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
				}).fail(function () {
					dfd.reject();
				});
			}
		});

		return dfd.promise();
	}

	/**
	 * @desc Shows a modal with map inside
	 *
	 * @param {Object} $target - map thumbnail jQuery object that gives context to which map should be shown
	 */
	function showMap($target) {
		var mapId = $target.data('map-id'),
			mapTitle = $target.data('map-title'),
			mapUrl = $target.data('map-url'),
			templatePath = 'extensions/wikia/WikiaInteractiveMaps/templates/' +
				'intMapParserTagMapIframe.mustache',
			cacheKey = 'wikia_interactive_maps_map_iframe';

		loadTemplate(templatePath, cacheKey)
			.done(function (template) {
				var iframe = mustache.render(template, {
					url: mapUrl
				});

				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(function (uiModal) {
						var modalConfig = {
							vars: {
								id: 'interactiveMap-' + mapId,
								size: 'large',
								title: mapTitle,
								content: iframe
							}
						};

						uiModal.createComponent(modalConfig, function (mapModal) {
							mapModal.show();
							tracker.track({
								trackingMethod: 'ga',
								category: 'map',
								action: tracker.ACTIONS.IMPRESSION,
								label: 'map-in-modal-shown',
								value: mapId
							});
						});
					});
				});
			})
			.fail(function () {
				showUnexpectedErrorModal();
			});
	}

	/**
	 * @desc Fired once an unexpected error (in example template didn't load) occurs, shows an error modal
	 *
	 * @see loadTemplate()
	 */
	function showUnexpectedErrorModal() {
		require(['wikia.ui.factory'], function (uiFactory) {
			uiFactory.init(['modal']).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'interactiveMapError',
						size: 'small',
						content: $.msg('wikia-interactive-maps-map-placeholder-error')
					}
				};

				uiModal.createComponent(modalConfig, function (errorModal) {
					errorModal.show();
				});
			});
		});
	}

	/** Attach events */
	$('body').on('click', '.wikia-interactive-map-thumbnail a', function (event) {
		event.preventDefault();
		showMap($(event.currentTarget));
	});
});
