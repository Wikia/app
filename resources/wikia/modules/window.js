/**
 * AMD module wrapping window global object
 */
(function(context) {
	'use strict';

	define('wikia.window', function() {
		return context;
	});

}(this));
