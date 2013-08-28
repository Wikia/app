/**
 * Helper module wrapping bootstrap tooltip plugin
 */

define( 'wikia.tooltip', [ 'wikia.window', 'jquery' ], function(window, $) {
	return (typeof $ !== 'undefined') ? $.tooltip : {};
});
