/**
 * Helper module wrapping $.ajax function coming from either:
 *  * Wikia.ajax (mobile skin)
 *  * jQuery.ajax (the rest)
 */
define('wikia.ajax', [require.optional('jquery'), require.optional('wikia.utils')], function($, Wikia) {
	return (typeof $ !== 'undefined') ? $.ajax : Wikia.ajax;
});
