require(['wikia.querystring', 'wikia.window'], function (qs, w) {
	'use strict';

	var doc = w.document,
		body = doc.getElementsByTagName('body')[0],

		// create map modal assets
		cacheKey = 'wikia_interactive_maps_create_map',
		source = {
			messages: ['WikiaInteractiveMapsCreateMap'],
			scripts: ['int_map_create_map_js'],
			styles: ['extensions/wikia/WikiaInteractiveMaps/css/intMapCreateMap.scss'],
			mustache: [
				'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapModal.mustache',
				'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapTileSet.mustache',
				'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPreview.mustache'
			]
		};

	// attach handlers
	body.addEventListener('change', function (event) {
		var target = event.target;

		if (target.id === 'orderMapList') {
			sortMapList(target.value);
		}
	});

	body.addEventListener('click', function (event) {
		var targetId = event.target.id,
			isLoggedInUser = (w.wgUserName !== null);

		if (!isLoggedInUser && targetId === 'createMap') {
			w.UserLoginModal.show({
				origin: 'wikia-int-map-create-map',
				callback: function () {
					w.UserLogin.forceLoggedIn = true;
					loadModal(convertSource(source), cacheKey);
				}
			});
		} else if (isLoggedInUser && targetId === 'createMap') {
			loadModal(convertSource(source), cacheKey);
		}
	});


	/**
	 * @desc reload the page after choosing ordering option
	 * @param {string} sortType - sorting method
	 */

	function sortMapList(sortType) {
		qs().setVal('sort', sortType, false).goTo();
	}

	/**
	 * @desc loads all assets for create map modal and initialize it
	 * @param {object} source - object with paths to different assets
	 * @param {string} cacheKey - local storage key
	 */

	function loadModal(source, cacheKey) {
		getAssets(source, cacheKey).then(function (assets) {
			addAssetsToDOM(assets);

			require(['wikia.intMaps.createMap.modal'], function (createMap) {
				createMap.init(assets.mustache);
			});
		});
	}

	/**
	 * @desc gets assets
	 * @param {object} source - object with paths to different assets
	 * @param {string} cacheKey - local storage key
	 * @returns {object} - promise
	 */

	function getAssets(source, cacheKey) {
		var dfd = new $.Deferred(),
			assets;

		require(['wikia.cache'], function (cache) {
			assets = cache.getVersioned(cacheKey);

			if (assets) {
				dfd.resolve(assets);
			} else {
				require(['wikia.loader'], function (loader) {
					loader({
						type: loader.MULTI,
						resources: source
					}).done(function (assets) {
						dfd.resolve(assets);
					});
				});
			}
		});

		return dfd.promise();
	}

	/**
	 * @desc adds scripts and styles to DOM
	 * @param {object} assets - object with assets
	 */

	function addAssetsToDOM(assets) {
		require(['wikia.loader'], function (loader) {
			loader.processScript(assets.scripts);
			loader.processStyle(assets.styles);
		});
	}

	/**
	 * @desc converts paths to assets in arrays to comma separated strings
	 * @param {object} source - object with arrays of paths to different type assets
	 * @returns {object} - object with arrays converted to comma separated strings
	 */

	function convertSource(source) {
		var convertedSource = {};

		Object.keys(source).forEach(function (type) {
			convertedSource[type] = source[type].join();
		});

		return convertedSource;
	}
});
