define('ext.wikia.adEngine.monetizationsServiceHelper', [
	'wikia.cache',
	'wikia.loader',
], function (cache, loader) {
	'use strict';

	var assets,
		isLoaded = false,
		cacheKey = 'monetization_ads',
		ttl = 604800;

	/**
	 * @desc loads all assets for monetization ads
	 */
	function loadAssets() {
		assets = cache.getVersioned(cacheKey);
		if (!isLoaded) {
			if (assets) {
				loader.processStyle(assets[0]);
				loader.processScript(assets[1]);
			} else {
				loader({
					type: loader.MULTI,
					resources: {
						styles: '/extensions/wikia/MonetizationModule/styles/MonetizationModule.scss',
						scripts: 'monetization_module_js'
					}
				}).done(function (res) {
					var script = res.scripts,
						style = res.styles;

					loader.processStyle(style);
					loader.processScript(script);

					cache.setVersioned(cacheKey, [style, script], ttl);
				});
			}
			isLoaded = true;
		}
	}

	return {
		loadAssets: loadAssets
	};
});
