/**
 * Pure JS implementation of a cookie setter/getter to use in generic components
 * that shouldn't rely on jQuery's cookie plugin (e.g. AdEngine)
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

(function(){
	// this module needs to be also available via a namespace for access early in the process
	if(!window.Wikia) window.Wikia = {};//namespace
	window.Wikia.Cookies = cookieCutter();//late binding

	if(window.define){
		//AMD
		define('cookies', function(){
			return window.Wikia.Cookies;
		});
	}

	function cookieCutter(){
		/** @private **/

		var cookieReplaceRegEx1 = /^\s*/,
			cookieReplaceRegEx2 = /\s*$/,
			lastCookieContent,
			cookies;

		function fetchCookies(){
			var cookieString = document.cookie,
				pair,
				name,
				value,
				separated;

			if(lastCookieContent != cookieString){
				cookies = {};
				lastCookieContent = cookieString;
				separated = cookieString.split(';');

				for(var i = 0, m = separated.length; i < m; i++){
					pair = separated[i].split('=');
					name = pair[0].replace(cookieReplaceRegEx1, '').replace(cookieReplaceRegEx2, '');
					value = decodeURIComponent(pair[1]);
					cookies[name] = value;
				}
			}

			return cookies;
		}
		
		/** @public **/
		
		return {
			get: function(name){
				var val = fetchCookies()[name];

				return (typeof val !== 'undefined' ) ? val : null;
			},

			set: function(name, value, options){
				var expDate,
					cookieString = '',
					data = [];
				
				options = options || {};
				
				if(typeof value == 'undefined' || value === null){
					value = '';
					options.expires = -1;
				}

				if(options.expires){
					if(typeof options.expires == 'number'){
						expDate = new Date();
						expDate.setTime(expDate.getTime() + (options.expires));
					}else if(options.expires instanceof Date){
						expDate = options.expires;
					}
					
					//use expires attribute, max-age is not supported by IE
					data.push('; expires=' + expDate.toUTCString()); 
				}

				options.path && data.push('; path=' + options.path);
				options.domain && data.push('; path=' + options.domain);
				options.secure && data.push('; secure');

				cookieString = name + '=' + encodeURIComponent(value);

				for(var x = 0, y = data.length; x < y; x++){
					cookieString += data[x];
				}

				document.cookie = cookieString;
				return cookieString;
			}
		};
	}
})();