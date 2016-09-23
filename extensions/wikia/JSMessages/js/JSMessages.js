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
	 * @return string - localised message
	 */
	function JSMessages(nirvana, $, window) {
		var JSMessages = function(){
			// get the first function parameter then the rest are parameters to a message.
			// trim to avoid misses when newlines or spaces got added to the
			// argument ie. in multiline conditions in mustache templates.
			var key = (shift.call(arguments) || '').trim(),
			// default value to be returned
				ret = key;

			if (window.wgMessages) {
				ret = window.wgMessages[key] || ret;

				// the is a small design flaw in JSMessages - it can fetch messages for both, user language and content
				// language (although nobody uses the later method right now). But all of them are stored in the same
				// window.wgMessages so there is no way to determine message language. We assume the user language here,
				// but we might want to improve it in the future.
				ret = Plurals.process(ret, arguments, window.wgUserLanguage);

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

	// private module for plural support
	var Plurals = {
		// Default function used as a fallback for languages not listed in pluralRules
		defaultPluralRule: function(n) {
			return (n != 1) ? 1 : 0;
		},
		// Language-specific functions. One method can be common for several languages specified in the key
		pluralRules: {
			'ay bo cgg dz fa id ja jbo ka kk km ko ky lo ms su th tr tt ug uz vi wo zh zh-hans zh-hant zh-tw': function() {return 0;},
			'ach ak am arn br fil fr gun ln mfe mg mi nso oc pt-br ti wa': function(n) {return (n > 1) ? 1 : 0;},
			'cs sk': function(n) { return (n == 1) ? 0 : ( (n >= 2 && n <= 4) ? 1 : 2 );},
			'be bs ru sr uk': function(n) {return (n%10 == 1 && n%100 != 11) ? 0 : ( (n%10 >= 2 && n%10 <= 4 && (n%100 < 10 || n%100 >= 20)) ? 1 : 2 );},
			'jv': function(n) {return (n != 0) ? 1 : 0;},
			'mk': function(n) {return (n == 1 || n%10 == 1) ? 0 : 1;},
			'mnk': function(n) {return (n == 0) ? 0 : n == 1 ? 1 : 2;},
			'lv': function(n) {return (n%10 == 1 && n%100 != 11) ? 0 : ( (n != 0) ? 1 : 2 );},
			'kw': function(n) {return (n == 1) ? 0 : ( (n == 2) ? 1 : ( (n == 3) ? 2 : 3 ) );},
			'ro': function(n) {return (n == 1) ? 0 : ( (n == 0 || (n%100 > 0 && n%100 < 20)) ? 1 : 2 );},
			'ga': function(n) {return (n == 1) ? 0 : ( (n == 2) ? 1 : ( (n < 7) ? 2 : ( (n < 11) ? 3 : 4 ) ) );},
			'gd': function(n) {return (n == 1 || n == 11) ? 0 : (n == 2 || n == 12) ? 1 : (n > 2 && n < 20) ? 2 : 3;},
			'sl': function(n) {return (n%100 == 1) ? 0 : ( (n%100 == 2) ? 1 : ( (n%100 == 3 || n%100 == 4) ? 2 : 3 ) );},
			'pl': function(n) {return (n == 1) ? 0 : ( (n%10 >= 2 && n%10 <= 4 && (n%100 < 10 || n%100 >= 20)) ? 1 : 2 );},
			'csb': function(n) {return (n == 1) ? 0 : ( (n%10 >= 2 && n%10 <= 4 && (n%100 < 10 || n%100 >= 20)) ? 1 : 2 );},
			'lt': function(n) {return (n%10 == 1 && n%100 != 11) ? 0 : ( (n%10 >= 2 && (n%100 < 10 || n%100 >= 20)) ? 1 : 2 );},
			'cy': function(n) {return (n == 0) ? 0 : ( (n == 1) ? 1 : ( (n == 2) ? 2 : ( (n == 3) ? 3 : ( (n == 6) ? 4 : 5 ) ) ) );},
			'hr': function(n) {return (n%10 == 1 && n%100 != 11) ? 0 : ( (n%10 >= 2 && n%10 <= 4 && (n%100 < 10 || n%100 >= 20)) ? 1 : 2 );},
			'mt': function(n) {return (n == 1) ? 0 : ( (n == 0 || (n%100 > 1 && n%100 < 11)) ? 1 : ( (n%100 > 10 && n%100 < 20) ? 2 : 3 ) );},
			'ar': function(n) {return (n == 0) ? 0 : ( (n == 1) ? 1 : ( (n == 2) ? 2 : ( (n%100 >= 3 && n%100 <= 10) ? 3 : ( (n%100 >= 11 && n%100 <= 99) ? 4 : 5 ) ) ) );}
		},
		/**
		 * Return a function, which based on cardinality, returns the position of the plural form
		 *
		 * @param {string} lang Language code
		 * @return {function(number): number} Function for determining plural form number
		 */
		getPluralRuleFunction: function(lang) {
			if (typeof Plurals.pluralRules[lang] === "undefined") { //search for language plural rule function
				var ruleFunction = Plurals.defaultPluralRule,       // default function
					langs = [lang], mainLanguage = lang.split('-'), i;
				if (mainLanguage.length > 1) {
					langs.push(mainLanguage[0]);
				}
				for (i = 0; (i < langs.length) && (ruleFunction === Plurals.defaultPluralRule); i++) {
					var langRegexp = new RegExp('(?:^| )'+langs[i]+'(?: |$)');
					for (var langKey in Plurals.pluralRules) {
						if (Plurals.pluralRules.hasOwnProperty(langKey)){
							if (langRegexp.test(langKey)) {
								ruleFunction = Plurals.pluralRules[langKey];
								break;
							}
						}
					}
				}
				Plurals.pluralRules[lang] = ruleFunction;   // cache it so we won't search for it again
			}
			return Plurals.pluralRules[lang];
		},
		/**
		 * Return a plural form based on the cardinality
		 *
		 * @param {Array.<string>} forms Plural forms
		 * @param {function(number): number} ruleFunction Function which based on the cardinality, returns a plural form number
		 * @param {number} n Cardinality passed to ruleFunction
		 * @returns {string} Proper plural form
		 */
		getPlural: function(forms, ruleFunction, n) {
			var plural = isNaN(n) ? -1 : ruleFunction(n);  // in case of a missing cardinality, force using the last form
			// in case of doubts, MW uses the last plural form
			if ((plural < 0) || (plural >= forms.length)) {
				plural = forms.length - 1;
			}
			return forms[plural];
		},
		/**
		 * Process plural forms within a message. In case there is a problem with the parameters or the message
		 * itself, the {{PLURAL}} tag is not replaced.
		 *
		 * For example if the message is 'User $1 has {{PLURAL:$2|one edit|$2 edits}}' the result is
		 * * for arguments ['Joe', 1] -> 'User $1 has one edit'
		 * * for arguments ['John', 100] -> 'User $1 has $2 edits'
		 *
		 * @param {string} msg Message containing plural pattern {{PLURAL:$<number>|<plural forms>}}
		 * @param {Array.<string|number>} msgArguments Message arguments
		 * @param {string} language Language code
		 * @returns {string} Message with a plurals being replaced with a proper forms
		 */
		process: function(msg, msgArguments, language) {
			msg = msg.replace(/\{\{PLURAL:\$(\d+)\|([^\{\}]+)\}\}/gi, function(wholeMsg, variable, forms) {
				var cardinality = NaN;      // used in case of a missing argument or invalid argument value
				if ((variable > 0) && (variable <= msgArguments.length)) {
					cardinality = msgArguments[variable - 1];
					if (typeof cardinality !== "number") { // try converting it to a number
						cardinality = parseInt(cardinality);    // if it's not a number, it will be a NaN
					}
				}
				return Plurals.getPlural(forms.split('|'), Plurals.getPluralRuleFunction(language), cardinality);
			});
			return msg;
		}
	};

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
