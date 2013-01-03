/* globals Zepto */
(function(context, jQuery){

	/**
	 * JS version of wfMsg()
	 *
	 * Examples:
	 *
	 *  require('JSMessages', function(msg){
	 *
	 *  	msg('foo');
	 *  	msg('bar', 'test', 'foo');
	 *
	 *		msg.get();
	 *
	 *		msg.getForContent();
	 *  })
	 *
	 * or as a compatability support
	 *
	 * $.msg();
	 * $.getMessages();
	 * $.getMessagesForContent();
	 *
	 * @param key string - message name
	 * @param param string - message parameter #1
	 * @param param string - message parameter #2
	 * ...
	 * @return string - localised message
	 */
	function JSMessages(nirvana) {
		var JSMessages = function(){
			// get the first function parameter
			// then the rest are parameters to a message
			var key = Array.prototype.shift.call(arguments),
			// default value to be returned
				ret = key;

			if (window.wgMessages) {
				ret = wgMessages[key] || ret;

				// replace $1, $2, $3, ...  with parameters provided
				if (arguments && ret !== key && arguments.length) {
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
		 */
		JSMessages.get = function(packages, callback, language) {
			// list of packages was given
			if (typeof packages != 'string') {
				packages = Array.prototype.join.call(packages, ',');
			}

			// by default use user language
			language = language || window.wgUserLanguage;

			nirvana.sendRequest({
				type: 'GET',
				controller: 'JSMessages',
				method: 'getMessages',
				data: {
					packages: packages,
					uselang: language,
					cb: window.wgJSMessagesCB
				},
				callback: function(result) {
					window.wgMessages = $.extend(window.wgMessages || {}, result.messages);

					if (typeof callback == 'function') {
						callback();
					}
				}
			});
		};

		/**
		 * Load messages from given package(s) using content language
		 */
		JSMessages.getForContent = function(packages, callback) {
			JSMessages.get(packages, callback, window.wgContentLanguage);
		};

		return JSMessages;
	}

	//UMD inclusive
	if(jQuery){
		var msg = JSMessages(window.Nirvana);
		jQuery.extend(jQuery, {
			msg: msg,
			getMessages: msg.get,
			getMessagesForContent: msg.getForContent
		})
	}

	if (context.define && context.define.amd) {
		//AMD
		context.define('JSMessages', ['nirvana'], JSMessages);
	}
})(this, this.jQuery);