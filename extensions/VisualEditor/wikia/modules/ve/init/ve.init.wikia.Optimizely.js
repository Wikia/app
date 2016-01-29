/*!
 * Utility functions for running Optimizely A/B tests with VisualEditor
 */

( function () {
	/**
	 * @returns {number} The A/B test variant number for the Toolbar A/B test
	 */
	ve.init.wikia.ToolbarABTestVariantNumber = function () {
		var optimizely = window.optimizely,
			optimizelyId = window.wgDevelEnvironment ? '4721410313' : '4701112678';

		if (optimizely && optimizely.variationMap && optimizely.variationMap.hasOwnProperty(optimizelyId)) {
			return optimizely.variationMap[optimizelyId] || 0;
		}

		return 0;
	};
}() );
