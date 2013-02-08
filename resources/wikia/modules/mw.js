/**
 * AMD wrapper for mw global object
 */
(function(context) {
	define('mw', function() {
		return context.mw;
	});
}(this));
