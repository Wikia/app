/*!
 * Utility functions for running Optimizely A/B tests with VisualEditor
 */

/**
 * @returns {number} the correct optimizely id to activate depending on the current href
 */
ve.init.wikia.getToolbarABTestId = function () {
	// Production tests are split by language. This is done because each language has a separate engagement percentage
	var href = window.location.href;

	if ( window.wgDevelEnvironment ) {
		return 4721410313;
	} else if ( href.match(/http:\/\/sandbox-japan\.visualeditor\.wikia\.com/) ) {
		// Sandbox test
		return 4701112678;
	} else {
		switch ( window.wgContentLanguage ) {
			case 'ja':
				return 4701112678;
			case 'es':
				return 5003533755;
			case 'de':
				return 5013830116;
			case 'en':
				return 5003080344;
			default:
				return null;
		}
	}

	return null;
};

/**
 * @returns {number} The A/B test variant number for the Toolbar A/B test
 */
ve.init.wikia.getToolbarABTestVariantNumber = function () {
	var optimizely = window.optimizely,
		optimizelyId = ve.init.wikia.getToolbarABTestId();

	if ( optimizely && optimizely.variationMap && optimizely.variationMap.hasOwnProperty( optimizelyId ) ) {
		return optimizely.variationMap[optimizelyId] || 0;
	}
};

/**
 * Activates toolbar A/B test
 */
ve.init.wikia.activateToolbarABTest = function () {
	var optimizelyId = ve.init.wikia.getToolbarABTestId();

	if ( optimizelyId ) {
		window.optimizely.push( ['activate', optimizelyId] );
	}
};
