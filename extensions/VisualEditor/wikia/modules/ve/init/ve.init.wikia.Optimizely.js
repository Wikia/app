/*!
 * Utility functions for running Optimizely A/B tests with VisualEditor
 */

/**
 * Gets Optimizely ID for Toolbar A/B test
 * @returns {string}
 */
ve.init.wikia.getToolbarABTestId = function () {
	return window.wgDevelEnvironment ? '4721410313' : '4701112678';
};

/**
 * @returns {number} The A/B test variant number for the Toolbar A/B test
 */
ve.init.wikia.getToolbarABTestVariantNumber = function () {
	var optimizely = window.optimizely,
		optimizelyId = ve.init.wikia.getToolbarABTestId();

	if ( optimizely && optimizely.variationMap && optimizely.variationMap.hasOwnProperty(optimizelyId) ) {
		return optimizely.variationMap[optimizelyId] || 0;
	}

	return 0;
};

/**
 * Hook for activating experiment on VE load
 */
mw.hook( 've.activate' ).add( function () {
	window.optimizely.push( ['activate', ve.init.wikia.getToolbarABTestId()] );
});
