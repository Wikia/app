/* Javascript API for interacting with Mediawiki. The Mediawiki API for PHP is great, and it allows
 * for JSON responses. This Javascript API allows for interacting with that API from a web browser.
 * Why use an intermediary scripting layer, just call the Mediawiki api right on the page. Probably
 * because no one else was crazy enough to write an API in Javascript. :)
 *
 * The heart of the class is the apiCall function, which is the interface to the API directly. You
 * can use it directly and issue your own api calls to Mediawiki, or use one of the convenience
 * wrappers that wrap up common tasks into a tidy bundle.
 *
 * @author Nick Sullivan nick at sullivanflock.com
 *
 * Conventions used:
 * * Syntax checked with jslint. If you submit changes, please run them through there.
 *
 * * Careful variable scoping, every member variable is local, persistent variables are member
 *   variables of the Mediawiki object
 *
 *
 * Notes:
 * * This script is really just a thin interface to the PHP API, so use it's documentation for API
 *   calls - http://www.mediawiki.org/wiki/API
 *
 * * See test.html in this same directory for example uses.
 *
 * * Requires jQuery, http://jquery.com/ mostly for the underlying http work.
 *
 * * There are a few programming convenince methods included such as 'print_r' and 'empty', check
 *   them out too.
 *
 * * This is the full version with comments and all the goodies. Consider using jsmin to minify the
 *   javascript. But hey - you are a good javascript programmer, so you knew that.
 *
 * * Don't just call this from Wikia's servers. Host your own copy or we may be tempted to redirect
 *   all of your users to disneyland.com ;)
 *
 * * Contributions ENCOURAGED - please e-mail nick at sullivanflock.com
 *
 * * Firebug and debugLevel > 0 is your friend.
 *
 * * There is a Mediawiki status bar supplied that's helpful for letting the user know what's up
 *
 *
 * TODO:
 * * i18n of the messages
 * * More convenience wrappers
 *
 */

var Mediawiki = {
	// apiUrl must be on the same domain for write access
	apiUrl		: wgScriptPath + '/api.php',

	// How long to wait for request, in milliseconds
	apiTimeout	: 30000,

	// The higher the number, the more info. See Mediawiki.debug
	debugLevel	: 0,

	// http://www.mediawiki.org/wiki/Manual:$wgCookiePrefix
	cookiePrefix	: null,

	 // if using http://www.mediawiki.org/wiki/Manual:$wgCookieHttpOnly
	cookiePrefixApi	: "jsapi",

	// cookies used by the login
	cookieNames	: [ "UserID", "UserName", "Token", "_session" ]
};


/***  Methods are in alphabetical order. ***/


/* Issue an http request to the api, based on jQuery's ajax().
 * @param "apiParams" is an object of the params that are passed to the API, as defined in the
 * 	   Mediawiki documentation
 * @param callbackSuccess/Error params are the callbacks for success/failure
 * 	   Note: If no callbackSuccess function is supplied, then syncronous (blocking) mode will
 * 	   be used, and the response will be returned directly.
 * @param method is POST or GET
 * @param ajaxParams is an object that contains key values to be passed to jQuery's ajax function
 * @return either the ajax handle if using callbacks, or the actual data if no callbacks supplied
 */
Mediawiki.apiCall = function(apiParams, callbackSuccess, callbackError, method, ajaxParams){
   try {
	// Hard code the "json" parameter to the api call
	apiParams.format = "json";

	var p = {
		'url': Mediawiki.apiUrl,
		'data': apiParams,
		'type' : method || "GET",
		'timeout' : Mediawiki.apiTimeout
	};

	// Callbacks
	if (typeof callbackSuccess == "function"){
		p.success = callbackSuccess;
	} else {
		p.async = false;
		Mediawiki.waiting(Mediawiki.apiTimeout);
	}
	if (typeof callbackError == "function"){
		p.error = callbackError;
	} else {
		p.error = Mediawiki.error;
	}

	// Tell jQuery that the result is json so it returns a javascript object
	p.dataType = "json";

	// ajaxParams
	if (typeof ajaxParams == "object"){
		for (var param in ajaxParams){
			p[param] = ajaxParams[param];
		}
	}

	// POST vs GET
	if (p.type == "GET" ) {
		// Don't confuse p.data with p.diddy. He gets mad.
		p.url += '?' + Mediawiki.buildQueryString(p.data);
		p.data = null;
		Mediawiki.d("Fetching " + p.url, 2);
	} else {
		Mediawiki.d("POSTing data to " + p.url, 2, p.data);
	}

	var r = jQuery.ajax(p);

	// For async requests, parse the data.
	// If not, the callbacks will receive an object passed to the callback
	if (p.async === false) {
		Mediawiki.waitingDone();
		if (typeof r == "object" && !Mediawiki.e(r.responseText)){
			return Mediawiki.json_decode(r.responseText);
		} else {
			return false;
		}
	}

   } catch (e) {
	Mediawiki.error("API error");
	Mediawiki.d("API error: " + Mediawiki.print_r(e));
	return false;
   }

};


/* Build up a query string from the supplied array (nvpairs).
 * @param nvpairs - an assoc array (javascript object) containing name/value pairs
 * @param sep - the separator to use in between the values. Default "&"
 * @param - url encoded query string. empty if nvpairs is empty
 */
Mediawiki.buildQueryString = function(nvpairs, sep){
	if (Mediawiki.e(nvpairs)){
		return '';
	}
	if (Mediawiki.e(sep)){
		sep = '&';
	}

	var out = '';
	for(var name in nvpairs){
		out += sep + name + '=' + encodeURIComponent(nvpairs[name]);
	}

	return out.substring(sep.length);
};


/* Take a look at the result from the api call. If it looks ok, return true.
 * Otherwise, return the error message
 */
Mediawiki.checkResult = function (result){
	if (typeof result != "object"){
		// This isn't going to work out
		return "Error processing result";
	} else if (result.error) {
		return result.error.info;
	} else {
		return true;
	}
};

/* Set/get cookies. Thanks to http://plugins.jquery.com/project/Cookie
 * Note this won't work to read Mediawiki cookies if you have httpcookies set in Mediawiki.
 */
Mediawiki.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
	Mediawiki.d("Setting " + name + " cookie, with a value of " + value);
	options = options || {};
	if (Mediawiki.e(value)) {
	    value = '';
	    options.expires = -1;
	}
	var expires = '';
	if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
	    var d;
	    if (typeof options.expires == 'number') {
		d = new Date();
		d.setTime(d.getTime() + (options.expires));
	    } else {
		d = options.expires;
	    }
	    // use expires attribute, max-age is not supported by IE
	    expires = '; expires=' + d.toUTCString();
	}
	// CAUTION: Needed to parenthesize options.path and options.domain
	// in the following expressions, otherwise they evaluate to undefined
	// in the packed version for some reason...
	var path = options.path ? '; path=' + (options.path) : '';
	var domain = options.domain ? '; domain=' + (options.domain) : '';
	var secure = options.secure ? '; secure' : '';
	return document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
	var cookieValue = null;
	if (!Mediawiki.e(document.cookie)){
	    var cookies = document.cookie.split(';');
	    for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
		// Does this cookie string begin with the name we want?
		if (cookie.substring(0, name.length + 1) == (name + '=')) {
		    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
		    break;
		}
	    }
	}
	return cookieValue;
    }
};


/* Send a message to the debug console if available, otherwise alert */
Mediawiki.debug = function (msg, level){
	if (Mediawiki.e(Mediawiki.debugLevel)){
		return false;
	} else if (level > Mediawiki.debugLevel){
		return false;
	}

	// Firebug enabled
	if (typeof console != "undefined" && typeof console.firebug != "undefined"){
		console.log("Mediawiki: " + msg);
		if (Mediawiki.d.arguments.length > 2){
			console.dir(Mediawiki.d.arguments[2]);
		}
	// Yahoo logging console
	} else if (typeof YAHOO != "undefined" && typeof YAHOO.log != "undefined"){
		YAHOO.log(msg, "info", "Mediawiki");
		if (Mediawiki.d.arguments.length > 2){
			YAHOO.log(Mediawiki.print_r(Mediawiki.d.arguments[2]), "info", "Mediawiki");
		}
	} else if (typeof console != "undefined" && typeof console.log != "undefined"){
		console.log("Mediawiki: " + msg);
		if (Mediawiki.d.arguments.length > 2){
			console.log(Mediawiki.print_r(Mediawiki.d.arguments[2]));
		}
	}
	// No solution right now for browsers that don't have console

	return true;
};
Mediawiki.d = Mediawiki.debug; // Shortcut to reduce size of JS


/* Convenience wrapper for deleting an article. Obtains a token and then deletes */
Mediawiki.deleteArticle = function (title, reason, callbackSuccess, callbackError){
     try {
	var token = Mediawiki.getToken(title, "delete");
	if (token === false){
		Mediawiki.error("Error obtaining delete token, delete failed");
		return false;
	}

	var apiParams = {
		'token' : token,
		'action' : 'delete',
		'title'  : title,
		'reason'  : reason
	};

	return Mediawiki.apiCall(apiParams, callbackSuccess, callbackError, "POST");

      } catch (e) {
	Mediawiki.error("Error deleting article");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
      }
};


/* Main interface for editing/creating articles. The "article" param is an object contaiing
 * any of the properties listed in the api on:
 * http://www.mediawiki.org/wiki/API:Edit_-_Create%26Edit_pages
 * Of particular interest:
 *	title
 *	text
 *	section
 *	summary
 *	createonly/nocreate
 *	watch/unwatch
 */
Mediawiki.editArticle = function (article, callbackSuccess, callbackError){
	try {
		var token = Mediawiki.getToken(article.title, "edit");
		if (token === false){
			Mediawiki.error("Error obtaining edit token, edit failed");
			return false;
		}

		var apiParams = {
			'token' : token,
			'action' : 'edit'
		};

		// Pass thru
		for (var key in article){
			apiParams[key] = article[key];
		}

		return Mediawiki.apiCall(apiParams, callbackSuccess, callbackError, "POST");
	} catch (e) {
		Mediawiki.error("Error editing article");
		Mediawiki.d(Mediawiki.print_r(e));
		return false;
	}
};


/* Emulate php's empty(). Thanks to:
 * http://kevin.vanzonneveld.net/techblog/article/javascript_equivalent_for_phps_empty/
 * Nick wrote: added the check for empty arrays
 * Nick wrote: added the check for number that is NaN
 */
Mediawiki.empty = function ( v ) {

    if (v === "" ||
	v === 0 ||
	v === null ||
	v === false ||
	typeof v === "undefined" ||
	(typeof v === "number" && isNaN(v))){
	return true;
    } else if (typeof v === 'object') {
	for (var key in v) {
	    if (typeof v[key] !== 'function' ) {
	      return false;
	    }
	}
	return true;
    } else if (typeof v === 'array' && v.length === 0) {
	return true;
    }
    return false;
};
Mediawiki.e = Mediawiki.empty; // Shortcut to make the Javascript smaller


/* Default handler for errors from the API */
Mediawiki.error = function (msg){
	if (typeof msg == "object"){
		msg = Mediawiki.print_r(msg);
	}

	Mediawiki.updateStatus(msg, true);
	Mediawiki.d(msg);
};


/* Convenience wrapper for getting the end url for a redirect. Will use cache if allowed */
Mediawiki.followRedirect = function(title, useCache){
     try {
	if (typeof useCache == "undefined") {
		useCache = true;
	}

	if (Mediawiki.e(Mediawiki.redirectCache)){
		Mediawiki.redirectCache = {};
	}

	if (useCache && !Mediawiki.e(Mediawiki.redirectCache[title])){
		// Score!
		return Mediawiki.redirectCache[title];
	}

	var responseData = Mediawiki.apiCall({
		'action' : 'query',
		'prop' : 'info',
		'titles' : title,
		'intoken' : "edit",
		'redirects' : true
	});

	var out, cresult = Mediawiki.checkResult(responseData);
	if (cresult !== true) {
		Mediawiki.error("Error resolving redirect: " + cresult);
		return false;
	}

	if (!Mediawiki.e(responseData.query) && Mediawiki.empty(responseData.query.redirects)){
		out = title;
	} else {
		out = responseData.query.redirects[0]["to"];
	}

	// Store in cache
	Mediawiki.redirectCache[title] = out;

	return out;

     } catch (e) {
	Mediawiki.error("Error resolving redirect");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
     }
};

/* The mediawiki login cookies are prefixed. Look to see if we can figure it out by looking at the
 * cookie. null will be returned if there is no matching cookies, otherwise the string */
Mediawiki.getCookiePrefix = function( ) {
	// Try to determine it automagically with hokey regexp. Could [should?] we query the API?
	for (var i = 0; i < Mediawiki.cookieNames.length; i++) {
		var reg = new RegExp("([^ ;]*)" + Mediawiki.cookieNames[i] + "=[^;]");
		var match = document.cookie.match(reg);
		if (match === null ) {
			return null;
		}
	}

	// If it got this far, all the cookies were found, and match[1] contains the cookie prefix
	return match[1];
};


/* For the supplied Wiki Image, return the full url for including it in HTML.
 * @return url or false on error */
Mediawiki.getImageUrl = function(image){
	if (!image.match(/:/)){
		image = "File:" + image; // A little confusion on if I should use Image: here...
	}

	var apiParams = {
		'action' : 'query',
		'titles' : image,
		'prop' : "imageinfo",
		'iiprop' : 'url'
	};

	var result = Mediawiki.apiCall(apiParams);
	var cresult = Mediawiki.checkResult(result);
	if (cresult !== true) {
		Mediawiki.error("API Error pulling image url: " + cresult);
		return false;
	}

	try {
		for (var pageid in result.query.pages){
			return result.query.pages[pageid].imageinfo[0].url;
		}
		return false;
	} catch (e) {
		Mediawiki.e("Error pulling image url: " + Mediawiki.print_r(e));
		return false;
	}
};


/* There is a set of cleanup that Mediawiki does to user generated article title.
 * For example, changing spaces to underscores, capitilization of certain characters,
 * remove of others. Issue a call to the API to handle this translation
 */
Mediawiki.getNormalizedTitle = function(title){

	if (Mediawiki.e(Mediawiki.normalizedTitles)){
		Mediawiki.normalizedTitles = {};
	}

	if (!Mediawiki.e(Mediawiki.normalizedTitles[title])){
		// Score!
		return Mediawiki.normalizedTitles[title];
	}

	Mediawiki.d("Getting Normalized title for " + title);
	// TODO: is there a cheaper way to get this?
	var responseData = Mediawiki.apiCall({
		'action' : 'query',
		'prop' : 'info',
		'titles' : title,
		'intoken' : "edit"
	});

	var cresult = Mediawiki.checkResult(responseData);
	if (cresult !== true) {
		Mediawiki.error("API Error normalizing title: " + cresult);
		return false;
	}

	// We can get two different responses back here.
	// If it's a valid title, then it returns it directly
	// If not, it returns it "normalized".
	// If your page title isn't coming through the API, try normalizeTitle first
	var out;
	try {
		out =  responseData.query.normalized[0]["to"];
	} catch (e) {
		out =  title;
	}

	// Save in cache
	Mediawiki.normalizedTitles[title] = out;
	return out;
};


/* Obtain a token for the supplied tokenType (edit, delete, etc). This is the first step
 * in a few of the write operations, particularly those dealing with articles.
 * @param title (could supprt multiple if someone wants to build it out)
 * @tokenType - type of token. Example "edit"
 */
Mediawiki.getToken = function(titles, tokenType){
	if (typeof titles == "array"){
		Mediawiki.error("Sorry, multiple titles not yet supported for getToken");
	}

	Mediawiki.d("Getting " + tokenType + " token for " + titles);

	var responseData = Mediawiki.apiCall({
		'action' : 'query',
		'prop' : 'info',
		'titles' : titles,
		'intoken' : tokenType
	});

	var cresult = Mediawiki.checkResult(responseData);
	if (cresult !== true) {
		Mediawiki.error("API Error obtaining token: " + cresult);
		return false;
	}

	// We can get two different responses back here. If it's a valid title, then it returns it
	// directly If not, it returns it "normalized".
	if (!Mediawiki.e(responseData.query) && !Mediawiki.empty(responseData.query.pages)){
		if (!Mediawiki.e(responseData.query.normalized)){
			// If your page title isn't coming through the API, try normalizeTitle first
			return false;
		}
		for ( var artid in responseData.query.pages){
			return responseData.query.pages[artid][tokenType + "token"];
		}
	}
	return false;
};


/* Check the current page, and then the cookies for login information. Return username if logged in,
 * otherwise false */
Mediawiki.isLoggedIn = function( ){
	if (!Mediawiki.e(Mediawiki.UserName)){
		return Mediawiki.UserName;
	}

	var cookiePrefix = Mediawiki.getCookiePrefix();
	if (cookiePrefix === null){
		return false;
	} else {
		Mediawiki.pullLoginFromCookie(cookiePrefix);
		return Mediawiki.UserName;
	}
};


/* Simple convenience wrapper for json parsing. It will be nice when most browsers support JSON
 * natively. For now it's just IE 8+, Safari 4+, Firefox 3.1+
 * http://tinyurl.com/n5qnlb
 */
Mediawiki.json_decode = function (json){
	if (typeof JSON != "undefined"){
		// For browsers that support it, it's more better.
		return JSON.parse(json);
	} else {
		try {
			var anon;
			eval('anon = ' + json + ';');
			return anon;
		} catch (e){
			Mediawiki.error("Error parsing json string '" + json +
				"'. Details: " + Mediawiki.print_r(e));
			return false;
		}
	}
};

/* Take a look at the cookies for the login info
 * Note this won't work to read Mediawiki cookies if you have httpcookies set in Mediawiki.
 */
Mediawiki.pullLoginFromCookie = function(cookiePrefix){
	for (var i = 0; i < Mediawiki.cookieNames.length; i++) {
		var cookieName = Mediawiki.cookieNames[i];
		Mediawiki[cookieName] = Mediawiki.cookie(cookiePrefix + cookieName);
	}
};


/* Convenience wrapper for http://www.mediawiki.org/wiki/API:Login */
Mediawiki.login = function (username, password, callbackSuccess, callbackError, token){
	if (Mediawiki.isLoggedIn()){
		Mediawiki.d("You are already logged in");
		return null;
	}

	var apiParams = {
		'action' : 'login',
		'lgname' : username,
		'lgpassword' : password,
		'token' : (token?token:''),
	};
	Mediawiki.loginCallbackSuccess = callbackSuccess;
	Mediawiki.loginCallbackError = callbackError;
	
	// Since newer MediaWikis will have a response of NeedToken, store the values for resubmission:
	Mediawiki.loginUsername = username;
	Mediawiki.loginPassword = password;

	Mediawiki.waiting();
	return Mediawiki.apiCall(apiParams, Mediawiki.loginCallback, callbackError, "POST");
};


Mediawiki.loginCallback = function(result) {
	Mediawiki.waitingDone();
	var cresult = Mediawiki.checkResult(result);
	if (cresult !== true) {
		Mediawiki.error("API Error logging in: " + cresult);
		return;
	}
	try {
		if (result.login.result == "Success"){
			// It seems safer for the user's password to clear it out of the JS variable now that it isn't needed for resubmission anymore.
			Mediawiki.loginPassword = '';

			Mediawiki.setLoginSession(result.login);
			Mediawiki.runCallback(Mediawiki.loginCallbackSuccess);

		} else if (result.login.result == "WrongPass" || result.login.result == "EmptyPass" ||
			   result.login.result == "WrongPluginPass"){
			Mediawiki.runCallback(Mediawiki.loginCallbackError, "Invalid Password");
		} else if (result.login.result == "NotExists" || result.login.result == "Illegal" ||
			   result.login.result == "NoName"){
			Mediawiki.runCallback(Mediawiki.loginCallbackError, "Invalid Username");
		} else if (result.login.result == "NeedToken") {
			var token = result.login.token;
			Mediawiki.d("Got login token, resubmitting with token...");
			Mediawiki.login(Mediawiki.loginUsername, Mediawiki.loginPassword, Mediawiki.loginCallbackSuccess, Mediawiki.loginCallbackError, token);
		} else {
			Mediawiki.error("Unexpected response from api when logging in: " + result.login.result);
			throw ("Unexpected response from api when logging in");
		}


	} catch (e) {
		// Javascript Error processing login
		Mediawiki.error("Javascript Error Logging in...");
		Mediawiki.d(Mediawiki.print_r(e));
	}
};


/* Convenience wrapper for  http://www.mediawiki.org/wiki/API:Logout */
Mediawiki.logout = function (callbackSuccess){
	Mediawiki.apiCall({"action" : "logout"}, callbackSuccess);

	var cookiesToo = false;
	if (Mediawiki.getCookiePrefix() == Mediawiki.cookiePrefixApi){
		cookiesToo = true;
	}
	// Clear member variables
	for (var i = 0; i < Mediawiki.cookieNames.length; i++) {
		var cookieName = Mediawiki.cookieNames[i];
		Mediawiki[cookieName] = null;

		// If the api cookie prefix is used, then clear those cookies as well
		if (cookiesToo){
			Mediawiki.cookie(Mediawiki.cookiePrefixApi + cookieName, "");
		}
	}

};


/* Parse the selected text and return the html */
Mediawiki.parse = function (text){
	var responseData = Mediawiki.apiCall({
			"action": "parse",
			"text": text }, null, null, "POST");

	if (Mediawiki.e(responseData.parse) || Mediawiki.e(responseData.parse.text)){
		return false;
	} else {
		// Strip the parse comment
		return responseData.parse.text['*'].replace(/<!--[^>]*-->/, '');
	}
};


/* Javascript equivalent of php's print_r.
 * http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
Mediawiki.print_r = function (arr,level) {
	var text = "\n", padding = "";
	if(!level) { level = 0; }

	// saving a crash if you try to do something silly like print_r(top);
	if (level > 6) { return false; }

	//The padding given at the beginning of the line.
	for(var j=0;j<level+1;j++) {
		padding += "	";
	}

	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		for(var item in arr) {
			var value = arr[item];

			if(typeof(value) == 'object') { //If it is an array,
				text += padding + "'" + item + "' ...";
				text += Mediawiki.print_r(value,level+1);
			} else {
				text += padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		text = "'"+arr+"'";
	}
	return text;
};


/* Pull article content http://www.mediawiki.org/wiki/API:Query */
Mediawiki.pullArticleContent = function (title, callback, options){
	var apiParams = {
		'action' :'query',
		'titles' : title,
		'prop' : 'revisions',
		'rvprop' : 'content'
	};

	if (typeof options == "object") {
		// Pass thru
		for (var option in options){
			apiParams[option] = options[option];
		}
	}

	// Store the callback
	Mediawiki.pullArticleCallback = callback;

	return Mediawiki.apiCall(apiParams, Mediawiki.pullArticleContentCallback, callback);
};


Mediawiki.pullArticleContentCallback = function (result) {
	var cresult = Mediawiki.checkResult(result);
	if (cresult !== true) {
		Mediawiki.error("API Error pulling content: " + cresult);
		return;
	}
	try {
		if (!Mediawiki.e(result.query.pages[-1])) {
			// Missing article
			Mediawiki.runCallback(Mediawiki.pullArticleCallback, null);
		} else {
			for (var pageid in result.query.pages){
				var content = result.query.pages[pageid].revisions[0]['*'];
				break;
			}

			if (Mediawiki.e(content)) {
				content = null;
			}

			Mediawiki.runCallback(Mediawiki.pullArticleCallback, content);
		}


	} catch (e) {
		// Javascript Error
		Mediawiki.error("Error during login callback");
		Mediawiki.d(Mediawiki.print_r(e));
	}
};


// If called through the API, there are several steps. Just use action=render
Mediawiki.pullArticleHtml = function (title, callback){
	var urlParams = {
		'action' :'render',
		'title' : title
	};

	return jQuery.get( Mediawiki.apiUrl.replace(/api.php/, 'index.php'), urlParams, callback);
};


/* Run the supplied callback, optionally with the supplied argument */
Mediawiki.runCallback = function(callback, arg){
	var parens = "()";
	if (typeof arg != "undefined") {
		parens = '(arg)';
	}
	if (typeof callback == "string" && typeof window[callback] == "function"){
		return eval(callback + parens + ";");
	} else if (typeof callback == "function"){
		var anonFunc = callback;
		return eval("anonFunc" + parens + ";");
	}
};


Mediawiki.setLoginSession = function(vars) {
	Mediawiki.UserID = vars.lguserid;
	Mediawiki.UserName = vars.lgusername;
	Mediawiki._session = vars.sessionid;
	Mediawiki.Token = vars.lgtoken;
	Mediawiki.cookieprefix = vars.cookieprefix;

	if (!document.cookie.match(new RegExp(Mediawiki.cookieprefix + "UserID"))){

		// They must be using http://www.mediawiki.org/wiki/Manual:$wgCookieHttpOnly
		// Set our own cookies with a different prefix
		for (var i = 0; i < Mediawiki.cookieNames.length; i++){
			var c = Mediawiki.cookieNames[i];
			Mediawiki.cookie(Mediawiki.cookiePrefixApi + c, Mediawiki[c]);
		}
	}
};


Mediawiki.updateStatus = function(msg, isError, timeout){

	if (Mediawiki.e(Mediawiki.statusBar)) {
		Mediawiki.statusBar = new MediawikiStatusBar();
	}

	if ( isError ){
		Mediawiki.waitingDone(); // catch all
		Mediawiki.statusBar.show(msg, timeout || 30000, true);
	} else {
		Mediawiki.statusBar.show(msg, timeout || Mediawiki.apiTimeout, false);
	}
};


/* Indicate to the user that the API is working (change the cursor ) */
Mediawiki.waiting = function (timeout){
	$("body").css("cursor", "wait");
	timeout = timeout || Mediawiki.apiTimeout;
	window.setTimeout( function(){ Mediawiki.waitingDone(); }, timeout);
};


Mediawiki.waitingDone = function (){
	$("body").css("cursor", "auto");
};



/* A status bar at the bottom of the window that let's the user know what's going on.
 * Thanks to http://www.west-wind.com/WebLog/posts/388213.aspx */
var MediawikiStatusBar = function (sel,options) {
	var _I = this;
	var _sb = null;

	// options
	this.elementId = "_showstatus";
	this.prependMultiline = true;
	this.showCloseButton = true;
	this.closeTimeout = 5000;

	this.cssClass = "statusbar";
	this.errorClass = "statusbarerror";
	this.closeButtonClass = "statusbarclose";
	this.additive = false;

	$.extend(this,options);

	if (sel) {
		_sb = $(sel);
	}

	// create statusbar object manually
	if (!_sb) {
		_sb = $("<div id='_statusbar' class='" + _I.cssClass + "'>" +
		    "<div class='" + _I.closeButtonClass +  "'>" +
		    (_I.showCloseButton ? " </div></div>" : "") ).appendTo(document.body).show();
	}

	if (_I.showCloseButton) {
		$("." + _I.cssClass).click(function(e) { $(_sb).fadeOut(); });
	}


	this.show = function(message,timeout,isError) {
		if (_I.additive) {
			var html = "<div style='margin-bottom: 2px;' >" + message + "</div>";
			if (_I.prependMultiline) {
				_sb.prepend(html);
			} else {
				_sb.append(html);
			}
		} else {
			if (!_I.showCloseButton) {
			 	_sb.text(message);
			} else {
				var t = _sb.find("div.statusbarclose");
				_sb.text(message).prepend(t);
			}
		}

		if (isError) {
		    _sb.addClass(_I.errorClass);
		} else {
		    _sb.removeClass(_I.errorClass);
		}

		_sb.show();

		timeout = timeout || _I.closeTimeout;
		if (timeout){
			window.setTimeout( function(){ _I.release(); }, timeout);
		}

	};

	this.release = function() {
		if(Mediawiki.statusBar) {
			$(_sb).fadeOut("slow");
		}
	};
};
