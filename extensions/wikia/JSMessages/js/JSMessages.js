(function(context){
	var shift = Array.prototype.shift,
		modulePrefix = 'ext.jsmessages.';

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
	 * or as a compatibility support
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
	 * @return {mw.Message} - localised message object
	 */
	function JSMessages(mw, $) {
		var JSMessages = function(){
			// get the first function parameter then the rest are parameters to a message.
			// trim to avoid misses when newlines or spaces got added to the
			// argument ie. in multiline conditions in mustache templates.
			var key = (shift.call(arguments) || '').trim();

			return new mw.Message(mw.messages, key, arguments).text();
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

			// by default use user language
			mw.config.set('wgUserLanguageTemp', mw.config.get('wgUserLanguage'));
			if (language) {
				mw.config.set('wgUserLanguage', language);
			}

			// append prefix
			if ($.isArray(packages)) {
				packages = packages.map(function(x) {
					return modulePrefix + x;
				});
			} else {
				packages = modulePrefix + packages;
			}

			mw.loader.using(packages).
				then(function(result) {
					if (typeof callback == 'function') {
						callback();
					}

					mw.config.set('wgUserLanguage', mw.config.get('wgUserLanguageTemp'));

					// resolve deferred object
					dfd.resolve();
				}).
				fail(function() {
					mw.config.set('wgUserLanguage', mw.config.get('wgUserLanguageTemp'));
					// error handling
					dfd.reject();
				});

			return dfd.promise();
		};

		/**
		 * Load messages from given package(s) using content language
		 */
		JSMessages.getForContent = function(packages, callback) {
			return JSMessages.get(packages, callback, mw.config.get('wgContentLanguage'));
		};

		return JSMessages;
	}

	//UMD inclusive
	if(jQuery){
		var jsm = JSMessages(mediaWiki, jQuery);
		jQuery.extend(jQuery, {
			msg: function () {
				return jsm.apply(this, arguments);
			},
			getMessages: jsm.get,
			getMessagesForContent: jsm.getForContent
		})
	}

	if (context.define && context.define.amd) {
		//AMD
		context.define('JSMessages', ['mw', 'jquery'], JSMessages);
	}
})(this);
