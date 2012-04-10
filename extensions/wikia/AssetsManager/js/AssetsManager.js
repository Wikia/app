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
 *		templates - an array of objects with the following fields: controllerName, methodName and an optional params
 *		styles - comma-separated list of SASS files
 *		scripts - comma-separated list of AssetsManager groups
 *		messages - comma-separated list of JSMessages packages (messages are registered automagically)
 *		ttl - cache period for both varnish and browser (in seconds)
 *		callback - function to be called with fetched JSON object
 *
 *  Returns object with all requested resources
 *
 *  Example: Wikia.getMultiTypePackage({
 *		messages: 'EditPageLayout',
 *		scripts: 'oasis_jquery,yui',
 *		styles: 'path/to/style/file'
 *		templates: [{
 *			controllerName: 'UserLoginSpecialController',
 *			methodName: 'index',
 *			param: {
 *				useskin: 'wikiamobile'
 *			}
 *		}]
 *	});
 */
window.Wikia.getMultiTypePackage = function(options) {
	var request = {},
		styles = options.styles,
		scripts = options.scripts,
		messages = options.messages,
		templates = options.templates,
		callback = options.callback,
		ttl = options.ttl,
		send = false;

	if(typeof styles === 'string'){
		request.styles = styles;
		send = true;
	}

	if(typeof scripts === 'string'){
		request.scripts = scripts;
		send = true;
	}

	if(typeof messages === 'string'){
		request.messages = messages;
		send = true;
	}

	if(typeof templates != 'undefined'){
		// JSON encode templates entry
		request.templates = (typeof templates === 'object') ? JSON.stringify(templates) : templates;
		send = true;
	}

	if(typeof ttl === 'string'){
		request.ttl = ttl;
	}

	if(send){
		// add a cache buster
		request.cb = wgStyleVersion;

		$.nirvana.getJson('AssetsManagerController', 'getMultiTypePackage', request, function(resources) {
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
		firstScript = document.getElementsByTagName('script')[0];

	script.type = 'text/javascript';
	script.text = js;

	// add it to DOM
	firstScript.parentNode.insertBefore(script, firstScript);
};

/**
 * Apply given CSS code by adding an inline <style> tag to document <body> tag
 *
 * css - CSS code to be applied
 */
window.Wikia.processStyle = function(css) {
	var style = document.createElement('style');
	style.type = 'text/css';

	if (style.styleSheet) {
		// for *&$#^# IE
		style.styleSheet.cssText = css;
	} else {
		// for web browsers
		style.appendChild(document.createTextNode(css));
	}

	document.getElementsByTagName('head')[0].appendChild(style);
};
