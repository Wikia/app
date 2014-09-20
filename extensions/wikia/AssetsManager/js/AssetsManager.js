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
 *		templates - an array of objects with the following fields: controller, method and an optional params (parameters for the controller method)
 *		styles - comma-separated list of SASS files
 *		scripts - comma-separated list of AssetsManager groups
 *		messages - comma-separated list of JSMessages packages (messages are registered automagically)
 * 		mustache - comma-separated list of paths to Mustache-powered templates
 * 		handlebars - comma-separated list of paths to Handlebars-powered templates
 *		params - an object with all the additional parameters for the request (e.g. useskin, forceprofile, etc.)
 *		callback - function to be called with fetched JSON object
 *
 *  Returns object with all requested resources
 *
 *  Example: Wikia.getMultiTypePackage({
 *		messages: 'EditPageLayout',
 *		scripts: 'oasis_jquery,yui',
 *		styles: 'path/to/style/file'
 *		mustache: 'extensions/wikia/MyExy/templates/index.mustache',
 *		templates: [{
 *			controller: 'MyController',
 *			method: 'getPage',
 *			params: {
 *				page: 1
 *			}
 *		}],
 *		params: {
 *			useskin: 'skinname'
 *		}
 *	});
 */
window.Wikia.getMultiTypePackage = function(options) {
	var request = {},
		templates = options.templates,
		fieldsToCopy = ['styles', 'scripts', 'messages', 'mustache', 'handlebars'],
		callback = options.callback,
		params = options.params,
		send = false;

	$.each(fieldsToCopy, function() {
		if (typeof options[this] === 'string') {
			request[this] = options[this];
			send = true;
		}
	});

	if(typeof templates != 'undefined'){
		// JSON encode templates entry
		request.templates = (typeof templates === 'object') ? JSON.stringify(templates) : templates;
		send = true;
	}

	if(typeof params === 'object'){
		request = $.extend(request, params);
	}

	if(send){
		// add a cache buster
		request.cb = wgStyleVersion;

		// return promise
		return $.nirvana.getJson('AssetsManagerController', 'getMultiTypePackage', request, function(resources) {
			// "register" JS messages
			if (resources.messages) {
				wgMessages = $.extend(wgMessages, resources.messages);
			}

			if (typeof callback === 'function') {
				callback(resources);
			}
		});
	}else{
		throw 'No resources to load specified';
	}
};

/**
 * Evaluate given JS code by adding an inline <script> tag to document <body> tag
 *
 * js - JS code to be evaluated
 */
window.Wikia.processScript = function(js) {
	var script = document.createElement('script'),
		head = document.head || document.getElementsByTagName('head')[0];

	script.type = 'text/javascript';
	script.text = js;

	// add it to DOM
	head.appendChild(script);
};

/**
 * Apply given CSS code by adding an inline <style> tag to document <body> tag
 *
 * css - CSS code to be applied
 */
window.Wikia.processStyle = function(css) {
	var style = document.createElement('style'),
		head = document.head || document.getElementsByTagName('head')[0];

	style.type = 'text/css';

	if (style.styleSheet) {
		// for *&$#^# IE
		style.styleSheet.cssText = css;
	} else {
		// for web browsers
		style.appendChild(document.createTextNode(css));
	}

	head.appendChild(style);
};

/**
 * Fetch AM group(s)
 *
 * @param groups string or array of AM groups to be fetched
 * @param callback function function to call when request is completed
 */
window.Wikia.getAMgroups = function(groups, callback) {
	return $.getScript($.getAssetManagerGroupUrl(groups), callback);
};
