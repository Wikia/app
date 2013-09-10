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
		defaultPluralRule: function(n) {
			return (n != 1) ? 1 : 0;
		},
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
		 * @param lang string - language code
		 * @return function - function which takes an integer parameter and returns a plural definition number
		 */
		getPluralRuleFunction: function(lang) {
			if (typeof Plurals.pluralRules[lang] === "undefined") { //search for language plural rule function
				var ruleFunction = Plurals.defaultPluralRule;       // default function
				var langRegexp = new RegExp('(?:^| )'+lang+'(?: |$)');
				for (var langKey in Plurals.pluralRules) {
					if (Plurals.pluralRules.hasOwnProperty(langKey)){
						if (langRegexp.test(langKey)) {
							ruleFunction = Plurals.pluralRules[langKey];
							break;
						}
					}
				}
				Plurals.pluralRules[lang] = ruleFunction;   // cache it for we won't search for it again
			}
			return Plurals.pluralRules[lang];
		},
		/**
		 * Return a plural form based on the cardinality
		 *
		 * @param forms array of plural forms
		 * @param ruleFunction function which based on the cardinality, returns a plural form number
		 * @param n integer cardinality
		 * @returns string proper plural form
		 */
		getPlural: function(forms, ruleFunction, n) {
			var plural = ruleFunction(n);
			if (plural < 0) {
				plural = 0;
			} else if (plural >= forms.length) {
				plural = forms.length - 1;
			}
			return forms[plural];
		},
		/**
		 * Process plural forms within a message
		 *
		 * For example if the message is 'User $1 has {{PLURAL:$2|one edit|$2 edits}}' the result is
		 * * for arguments ['Joe', 1] -> 'User $1 has one edit'
		 * * for arguments ['John', 100] -> 'User $1 has $2 edits'
		 *
		 * @param msg string message containing plural pattern {{PLURAL:$<number>|<plural forms>}}
		 * @param msgArguments array message arguments
		 * @param language string language code
		 * @returns string message with a plurals being replaced with a proper forms
		 */
		process: function(msg, msgArguments, language) {
			msg = msg.replace(/\{\{PLURAL:\$(\d+)\|([^\{\}]+)\}\}/g, function(wholeMsg, variable, forms) {
				if ((variable < 1) || (variable > msgArguments.length)) { // no argument was passed
					return wholeMsg;
				}
				var cardinality = msgArguments[variable - 1];
				if (typeof cardinality !== "number") { // try converting it to a number
					cardinality = parseInt(cardinality);
					if (isNaN(cardinality)) {
						return wholeMsg;
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
