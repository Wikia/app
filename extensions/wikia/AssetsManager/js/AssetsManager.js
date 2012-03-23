/**
 * Implements Wikia.getMultiTypePackage function for fetching JS/CSS/HTML
 * and JS messages in a single request (as JSON object)
 *
 * @author Macbre
 */
window.Wikia = window.Wikia || {};

/**
 *	request - json of key value pairs
 *  keys:
 *		templates - an array of object with the following fields: controllerName, methodName and an optional params
 *		styles - comma-separated list of SASS files
 *		scripts - comma-separated list of AssetsManager groups
 *		messages - comma-separated list of JSMessages packages (messages are registered automagically)
 *		ttl - cache period for both varnish and browser (in seconds)
 *
 *  callback - function to be called with fetched JSON object
 *
 *  Returns object with all requested resources
 *
 *  Example: Wikia.getMultiTypePackage({
 * 		messages: 'EditPageLayout',
 * 		scripts: 'oasis_jquery,yui',
 * 		templates: [{
 * 			controllerName: 'UserLoginSpecialController',
 * 			methodName: 'index'
 *		}]
 * 	});
 */
window.Wikia.getMultiTypePackage = function(request, callback) {
	// add a cache buster
	request = request || {};
	request.cb = wgStyleVersion;

	// JSON encode templates entry
	if (typeof request.templates === 'object') {
		request.templates = JSON.stringify(request.templates);
	}

	$.nirvana.getJson('AssetsManagerController', 'getMultiTypePackage', request, function(resources) {
		// "register" JS messages
		if (resources.messages) {
			wgMessages = $.extend(wgMessages, resources.messages);
		}

		if (typeof callback === 'function') {
			callback(resources);
		}
	});
}
