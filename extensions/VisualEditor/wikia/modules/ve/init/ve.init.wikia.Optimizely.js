/* global toolbarABTestVariantNumber:false */
/*!
 * Utility functions for running Optimizely A/B tests with VisualEditor
 */

/**
 * @returns {number} The A/B test variant number for the Toolbar A/B test
 */
ve.init.wikia.getToolbarABTestVariantNumber = function () {
	// toolbarABTestVariantNumber is set for variant #1 for all Optimizely toolbar experiments
	if ( typeof ( toolbarABTestVariantNumber ) === 'undefined' ) {
		return 0;
	}

	return toolbarABTestVariantNumber;
};

/**
 * Activates toolbar A/B test
 */
ve.init.wikia.activateToolbarABTest = function () {
	// Production tests are split by language. This is done because each language has a separate engagement percentage
	var optimizelyIds = window.wgDevelEnvironment ?
		[ '4721410313' ] : [ '4701112678', '5003080344', '5003533755', '5013830116' ];

	optimizelyIds.forEach( function (element) {
		window.optimizely.push( [ 'activate', element ] );
	});
};
