/**
 * JavaScript support for JSMessages
 *
 * Allows on-demand fetching of packages with messages and rendering of messages
 *
 * @see https://internal.wikia-inc.com/wiki/JSMessages
 */
(function($) {
	var loadedPackages = [];

	$.extend({
		/**
		 * JS version of wfMsg()
		 *
		 * Examples:
		 *
		 *  $.msg('foo');
		 *  $.msg('bar', 'test', 'foo');
		 *
		 * @param string key - message name
		 * @param string param - message parameter #1
		 * @param string param - message parameter #2
		 * ...
		 * @return string - localised message
		 */
		msg: function() {
			// get the first function parameter
			var key = Array.prototype.shift.call(arguments),
				// then the rest of parameters as message arguments
				params = arguments;

			// default value to be returned
			var ret = false;

			if (typeof wgMessages != 'undefined') {
				ret = wgMessages[key] || ret;

				// replace $1, $2, $3, ...  with parameters provided
				if (ret !== false && params && params.length) {
					$.each(params, function(i, param) {
						ret = ret.replace(new RegExp('\\$' + parseInt(i+1), 'g'), param);
					});
				}
			}

			return ret !== false ? ret : ('<' + key + '>');
		},

		/**
		 * Load messages from given package(s)
		 *
		 * @param string/array packages - package name or list of packages
		 * @param function callback - function to call when request is completed
		 * @param string language - optionally language code (fallbacks to user language)
		 * @return $.Deferred - promise object
		 */
		getMessages: function(packages, callback, language) {
			// set up deferred object
			var dfd = new jQuery.Deferred();

			// single of the single package was given
			if (typeof packages == 'string') {
				packages = [packages];
			}

			// by default use user language
			language = language || window.wgUserLanguage;

			$().log('loading ' + packages.join(',') + ' package(s) for "' + language + '"', 'JSMessages');

			// create a list of packages to be loaded
			// check the list of requested packages against already loaded
			var packagesToLoad = [];

			for (var i = 0, len = packages.length; i < len; i++) {
				if (loadedPackages.indexOf(packages[i]) === -1) {
					packagesToLoad.push(packages[i]);
				}
			}

			// load packages (if needed)
			if (packagesToLoad.length == 0) {
				$().log('package(s) are already loaded', 'JSMessages');

				if (typeof callback == 'function') {
					callback();
				}

				// resolve deferred object
				dfd.resolve();
			}
			else {
				$.get(wgScriptPath + '/wikia.php', {
					controller: 'JSMessages',
					method: 'getMessages',
					format: 'html',
					packages: packagesToLoad.join(','),
					uselang: language,
					cb: window.wgJSMessagesCB
				},
				function() {
					$().log(packagesToLoad.join(',') + ' package(s) loaded', 'JSMessages');

					if (typeof callback == 'function') {
						callback();
					}

					// resolve deferred object
					dfd.resolve();

					// these packages are loaded
					loadedPackages = loadedPackages.concat(packagesToLoad);
				}, 'script').error(function() {
					// error handling
					dfd.reject();
				});
			}

			return dfd.promise();
		},

		/**
		 * Load messages from given package(s) using content language
		 */
		getMessagesForContent: function(packages, callback) {
			return this.getMessages(packages, callback, window.wgContentLanguage);
		}
	});

})(jQuery);
