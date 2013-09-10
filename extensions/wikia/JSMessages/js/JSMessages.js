(function(context){
	var shift = Array.prototype.shift,
		join = Array.prototype.join;

	/**
	 * JS version of wfMsg()
	 *
	 * Examples:
	 *
	 *  require(['JSMessages'], function(msg){
	 *
	 *  	msg('foo');
	 *  	msg('bar', 'test', 'foo');
	 *
	 *		msg.get('foo');
	 *
	 *		msg.getForContent('foo');
	 *  })
	 *
	 * or as a compatability support
	 *
	 * $.msg();
	 * $.getMessages();
	 * $.getMessagesForContent();
	 *
	 * @see https://internal.wikia-inc.com/wiki/JSMessages
	 *
	 * @param key string - message name
	 * @param param string - message parameter #1
	 * @param param string - message parameter #2
	 * ...
	 * @return string - localised message
	 */
	function JSMessages(nirvana, $, window) {
		var JSMessages = function(){
			// get the first function parameter
			// then the rest are parameters to a message
			var key = shift.call(arguments),
			// default value to be returned
				ret = key;

			if (window.wgMessages) {
				ret = window.wgMessages[key] || ret;

				// replace $1, $2, $3, ...  with parameters provided
				if (ret !== key && arguments.length) {
					for(var i = 0, l = arguments.length; i < l; i++){
						ret = ret.replace(new RegExp('\\$' + (i+1), 'g'), arguments[i]);
					}
				}
			}

			return ret;
		};

		/**
		 * Load messages from given package(s)
		 *
		 * @param packages string/array - package name or list of packages
		 * @param callback function - function to call when request is completed
		 * @param language string - optionally language code (fallbacks to user language)
		 * @return $.Deferred - promise object
		 */
		JSMessages.get = function(packages, callback, language) {
			// set up deferred object
			var dfd = $.Deferred();

			// list of packages was given
			if (typeof packages != 'string') {
				packages = join.call(packages, ',');
			}

			// by default use user language
			language = language || window.wgUserLanguage;

			nirvana.
				sendRequest({
					type: 'GET',
					controller: 'JSMessages',
					method: 'getMessages',
					data: {
						packages: packages,
						uselang: language,
						cb: window.wgJSMessagesCB
					}
				}).
				then(function(result) {
					window.wgMessages = $.extend(window.wgMessages || {}, result.messages);

					if (typeof callback == 'function') {
						callback();
					}

					// resolve deferred object
					dfd.resolve();
				}).
				fail(function() {
					// error handling
					dfd.reject();
				});

			return dfd.promise();
		};

		/**
		 * Load messages from given package(s) using content language
		 */
		JSMessages.getForContent = function(packages, callback) {
			return JSMessages.get(packages, callback, window.wgContentLanguage);
		};

		return JSMessages;
	}

	//UMD inclusive
	if(jQuery){
		var msg = JSMessages(jQuery.nirvana, jQuery, context);
		jQuery.extend(jQuery, {
			msg: msg,
			getMessages: msg.get,
			getMessagesForContent: msg.getForContent
		})
	}

	if (context.define && context.define.amd) {
		//AMD
		context.define('JSMessages', ['wikia.nirvana', 'jquery', 'wikia.window'], JSMessages);
	}
})(this);
