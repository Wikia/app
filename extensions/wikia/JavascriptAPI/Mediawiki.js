/* API for interacting with Mediawiki.
 * Requires jQuery
 */

var Mediawiki = {
	// apiUrl must be on the same domain for write access
	apiUrl		: "/api.php",
	apiTimeout	: 10000, // How long to wait for request, in milliseconds
	debugLevel	: 0,
	cookiePrefix	: null, // http://www.mediawiki.org/wiki/Manual:$wgCookiePrefix
	cookiePrefixApi	: "jsapi", // used if using httpcookies
	cookieNames	: [ "UserID", "UserName", "Token", "_session" ],
	sessionLength	: 86400,
	statusBar	: null
};


/* Methods are in alphabetical order. */

Mediawiki.$ = function(id){
	return document.getElementById(id);
};


/* Issue an http request to the api, based on jQuery's ajax().
 * "apiParams" is an object of the params that are passed to the API, as defined in the Mediawiki documentation
 * callbackSuccess/Error params are the callbacks for success/failure
 * If no callbackSuccess function is supplied, then syncronous (blocking) mode will be used,
 * and the response will be returned directly.
 * method is POST or GET
 * ajaxParams is an object that contains key values to be passed to jQuery's ajax function
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
	//	p.type = "POST"; // POST is required for async. Silly. 
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

	// For async requests, parse the data. If not, the callbacks will receive an object passed to the callback
	if (p.async === false) {
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

/* Build up a query string from the supplied array (nvpairs). Optional separator, default ';' */
Mediawiki.buildQueryString = function(nvpairs, sep){
	if (Mediawiki.e(nvpairs)){
		return '';
	}
	if (Mediawiki.e(sep)){
		sep = '&';
	}

	var out = '';
	for(var name in nvpairs){
		out += sep + name + '=' + escape(nvpairs[name]);
	}

	return out.substring(sep.length);
};


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
	    expires = '; expires=' + d.toUTCString(); // use expires attribute, max-age is not supported by IE
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
		var cookie = cookies[i].replace( /^\s+|\s+$/g, "");
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
		
	return Mediawiki.apiCall(apiParams,  callbackSuccess, callbackError, "POST");

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


Mediawiki.error = function (msg){
	if (typeof msg == "object"){
		msg = Mediawiki.print_r(msg);
	}
	
	Mediawiki.updateStatus(msg, true);
	Mediawiki.d(msg);
};


Mediawiki.followRedirect = function(title){
     try {
	var responseData = Mediawiki.apiCall({
		'action' : 'query',
		'prop' : 'info',
		'titles' : title,
		'intoken' : "edit",
		'redirects' : true
	});

	if (!Mediawiki.e(responseData.query) && Mediawiki.empty(responseData.query.redirects)){
		return title;
	} else {
		return responseData.query.redirects[0]["to"];
	}

     } catch (e) {
	Mediawiki.error("Error resolving redirect");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
     }
};

/* The mediawiki login cookies are prefixed. Look to see if we can figure it out by looking at the cookie.
 * null will be returned if there is no matching cookies, otherwise the string */
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

	// We can get two different responses back here. If it's a valid title, then it returns it directly
	// If not, it returns it "normalized". 
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

/* Check the current page, and then the cookies for a login. Return username if logged in, otherwise false */
Mediawiki.isLoggedIn = function( ){
	try {
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
	} catch (e) {
		Mediawiki.error("Error checking login");
		Mediawiki.d(Mediawiki.print_r(e));
		return false;
	}
};

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
			Mediawiki.error("Error parsing json string '" + json + "'. Details: " + Mediawiki.print_r(e));
			return false;
		}
	}
};


Mediawiki.pullLoginFromCookie = function(cookiePrefix){
	for (var i = 0; i < Mediawiki.cookieNames.length; i++) {
		var cookieName = Mediawiki.cookieNames[i];
		Mediawiki[cookieName] = Mediawiki.cookie(cookiePrefix + cookieName);
	}
};


// http://www.mediawiki.org/wiki/API:Login
Mediawiki.login = function (username, password, callbackSuccess, callbackError){
	if (Mediawiki.isLoggedIn()){
		Mediawiki.d("You are already logged in");
		return null; 
	}	
			
	var apiParams = {
		'action' : 'login',
		'lgname' : username,
		'lgpassword' : password
	};
	Mediawiki.loginCallbackSuccess = callbackSuccess;
	Mediawiki.loginCallbackError = callbackError;
		
	return Mediawiki.apiCall(apiParams, Mediawiki.loginCallback, callbackError, "POST");
};


Mediawiki.loginCallback = function(result) {
	try {
		if (result.login.result == "Success"){

			Mediawiki.setLoginSession(result.login);
			Mediawiki.runCallback(Mediawiki.loginCallbackSuccess);

		} else if (result.login.result == "WrongPass" || result.login.result == "EmptyPass" || result.login.result == "WrongPluginPass"){
			Mediawiki.runCallback(Mediawiki.loginCallbackError, "Invalid Password");
		} else if (result.login.result == "NotExists" || result.login.result == "Illegal" || result.login.result == "NoName"){
			Mediawiki.runCallback(Mediawiki.loginCallbackError, "Invalid Username");
		} else {
			throw ("Unexpected response from api when logging in");
		}


	} catch (e) {
		// Javascript Error processing login
		Mediawiki.error("Javascript Error Logging in...");
		Mediawiki.d(Mediawiki.print_r(e));
	}
};


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
		text = "===>"+arr+"<===("+typeof(arr)+")";
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
	try {
		if (!Mediawiki.e(result.error)){
			Mediawiki.runCallback(Mediawiki.pullArticleCallback, "Error pulling article: " + result.error.info); 
		} else if (!Mediawiki.e(result.query.pages[-1])) {
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
		// Javascript Error processing login
		Mediawiki.error("Error during article callback");
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

	if (Mediawiki.statusBar === null) {
		Mediawiki.statusBar = new MediawikiStatusBar();
	}

	if ( isError ){
		Mediawiki.statusBar.show(msg, timeout || 10000, true);
	} else {
		Mediawiki.statusBar.show(msg, timeout || 3000, false);
	}
};

var MediawikiStatusBar = function (sel,options) {
	var _I = this;	     
	var _sb = null;
	
	// options     
	this.elementId = "_showstatus";
	this.prependMultiline = true;	
	this.showCloseButton = true; 
	this.closeTimeout = 10000;
	
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
