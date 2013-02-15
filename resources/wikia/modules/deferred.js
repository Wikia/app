/**
 * Helper module wrapping Promise pattern implementation coming from either:
 *  * deferred-js (mobile skin)
 *  * jQuery's deferred (the rest)
 *
 * @see https://github.com/heavylifters/deferred-js
 */

define('wikia.deferred', ['wikia.window', require.optional('jquery')], function(window, $) {
	return (typeof $ !== 'undefined') ? $.Deferred : window.Wikia.Deferred;
});
