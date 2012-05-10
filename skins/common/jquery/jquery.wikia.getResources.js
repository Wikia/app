/**
 * Fetches given list of JS / CSS / SASS files and then fires callback (RT #70163)
 *
 * @author macbre
 *
 * FIXME: added support for asset manager groups, but it assumes they are javascript (which is not always true)
 */
jQuery.getResources = function(resources, callback, failureFn) {
	var isJs = /.js(\?(.*))?$/,
		isCss = /.css(\?(.*))?$/,
		isSass = /.scss/,
		isGroup = /__am\/\d+\/group/,
		jsFiles = [],
		remaining = 0,
		dfd = new jQuery.Deferred();

	// called every time:
	//  - loader function is completed
	//  - yepnope loads all CSS / JS files
	var onComplete = function() {
		remaining--;

		// all files have been downloaded
		if (remaining === 0) {
			if (typeof callback == 'function') {
				callback();
			}

			// resolve deferred object
			dfd.resolve();
		}
	};

	// download files:
	// 1. call functions, i.e. library loaders
	// 2. prepare list of CSS and JS files to be fetched using async loader
	for (var n=0, len=resources.length; n<len; n++) {
		var resource = resources[n],
			type = '';

		//AssetsManager package object (e.g. as passed by JSSnippets)
		if(resource && resource.type && resource.url) {
			type = resource.type;
			resource = resource.url;
		}

		// "loader" function: $.loadYUI, $.loadJQueryUI
		if (typeof resource == 'function') {
			remaining++;
			resource.call(jQuery, onComplete);
		}
		// CSS /SASS files
		else if (type == 'css' || isCss.test(resource) || isSass.test(resource)) {
			remaining++;
			$.getCSS(resource, onComplete);
		}
		// JS files and Asset Manager groups are scripts
		else if (type == 'js' || isJs.test(resource) || isGroup.test(resource)) {
			//jsFiles.push(resource);
			remaining++;
			$.getScript(resource, onComplete);
		}
	}

	// use yepnope to fetch JS files
	/**
	if (jsFiles.length > 1) {
		remaining++;
		yepnope([{
			load: jsFiles,
			callback: function(url, result) {
				$().log(url, 'yepnope [loaded]');
			},
			complete: onComplete
		}]);
	}
	**/

	return dfd.promise();
};