/* global toolbarABTestVariantNumber:false */
/*!
 * Utility functions for running Optimizely A/B tests with VisualEditor
 */


/**
 * @returns {number} the correct optimizely id to activate depending on the current href
 */
ve.init.wikia.getToolbarABTestId = function () {
	// Production tests are split by language. This is done because each language has a separate engagement percentage
	var i, href = window.location.href,
		data = [
			{
				regex: /http:\/\/sandbox-japan\.visualeditor\.wikia\.com/,
				id: 4701112678
			},
			{
				regex: /http:\/\/ja\.[a-z0-9-]+\.wikia\.com/,
				id: 4701112678
			},
			{
				regex: /http:\/\/yaruo\.wikia\.com/,
				id: 4701112678
			},
			{
				regex: /http:\/\/es\.[a-z0-9-]+\.wikia\.com/,
				id: 5003533755
			},
			{
				regex: /http:\/\/de\.[a-z0-9-]+\.wikia\.com/,
				id: 5013830116
			},
			{
				regex: /http:\/\/[a-z0-9-]+\.wikia\.com/,
				id: 5003080344
			}
		];

	if ( window.wgDevelEnvironment ) {
		return 4721410313;
	} else {
		for ( i = 0; i < data.length; i++ ) {
			if ( href.match( data[i].regex ) ) {
				return data[i].id;
			}
		}
	}

	return 0;
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

	if ( optimizelyId > 0 ) {
		window.optimizely.push( ['activate', optimizelyId] );
	}
};
