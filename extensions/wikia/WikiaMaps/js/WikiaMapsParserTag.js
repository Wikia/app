require([
	'jquery',
	'wikia.mustache',
	'wikia.tracker',
	'wikia.loader'
	//FIXME: turning off ads on map because of JS errors - should be fixed in ADEN-1784
	//require.optional('ext.wikia.adEngine.slot.interactiveMaps')
], function ($, mustache, tracker, loader, mapAds) {
	'use strict';

	var assets;

	/**
	 * @desc Checks if template is cached in LocalStorage and if not loads it by using loader
	 *
	 * @todo Talk to Platform Team about making it global, so other teams can re-use it
	 *
	 * @param {Object} dependencies - asset dependencies
	 * @param {String} cacheKey the key in local storage
	 * @returns {$.Deferred}
	 */
	function loadAssets(dependencies, cacheKey) {
		var dfd = new $.Deferred();

		// check if assets are already loaded and in DOM
		if (assets) {
			dfd.resolve(assets);
		} else {
			require (['wikia.cache'], function (cache) {
				var assetsFromCache = cache.getVersioned(cacheKey);

				if (assetsFromCache) {
					dfd.resolve(assetsFromCache);
				} else {
					loader({
						type: loader.MULTI,
						resources: {
							mustache: dependencies.template,
							scripts: dependencies.scripts
						}
					}).done(function (data) {
						cache.setVersioned(cacheKey, data, 604800); //7days

						dfd.resolve(data);
					}).fail(function () {
						dfd.reject();
					});
				}
			});
		}

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
			dependencies = {
				template: 'extensions/wikia/WikiaMaps/templates/WikiaMapsParserTagMapIframe.mustache',
				scripts: 'wikia_maps_in_modal_display_js'
			},
			cacheKey = 'wikia_maps_map_iframe';

		loadAssets(dependencies, cacheKey)
			.done(function (loadedAssets) {
				var iframe = mustache.render(loadedAssets.mustache[0], {
					url: mapUrl,
					mapId: mapId
				});

				// add scripts to DOM
				if (!assets) {
					loader.processScript(loadedAssets.scripts);
					assets = loadedAssets;
				}

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

							if (mapAds) {
								mapAds.initSlot(mapModal.$element.find('.wikia-ad-interactive-map').get(0));
							}

							require(['wikia.maps.pontoBridge'], function (pontoBridge) {
								pontoBridge.init(mapModal.$content.find('#wikiaInteractiveMapIframe')[0]);
							});

							tracker.track({
								trackingMethod: 'analytics',
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

	if (mapAds) {
		$('.wikia-ad-interactive-map').each(function () {
			mapAds.initSlot(this);
		});
	}
});
