/* API for interacting with Mediawiki.
 * Requires jQuery
 */

Mediawiki = {
	// apiUrl must be on the same domain for write access
	apiUrl		: "/api.php",
	apiUser		: null, // Defaults to anon
	apiPass		: null, // Defaults to anon
	debugLevel	: 0,
	cookiePrefix	: null, // http://www.mediawiki.org/wiki/Manual:$wgCookiePrefix
	cookieMap	: {
		// Map of cookie names to member variables
		"UserID"	: "lguserid",
		"UserName"	: "lgusername",
		"Token"		:  "lgtoken",
		"_session"	: "sessionid"
	},
	sessionLength	: 86400,
	statusBar	: null
};


/* Methods are in alphabetical order. */

Mediawiki.$ = function(id){
	return document.getElementById(id);
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
	} else {
		alert("Mediawiki.debug: " + msg);
	}

	return true;
};
Mediawiki.d = Mediawiki.debug; // Shortcut to reduce size of JS


Mediawiki.deleteArticle = function (title, reason, callBackSuccess, callBackFailure){
     try {
	var token = Mediawiki.getToken(title, "delete"); 
	if (token === false){
		Mediawiki.error("Error obtaining delete token, delete failed");
		return false;
	}

	var urlParams = {
		'token' : token,	
		'action' : 'delete',
		'format' : 'json',
		'title'  : title,
		'reason'  : reason
	};
		
	Mediawiki.updateStatus("Deleting article...", true);
	Mediawiki.deleteArticleSuccess = callBackSuccess;
	Mediawiki.deleteArticleFailure = callBackFailure;

	Mediawiki.fetch( {
		'url': Mediawiki.apiUrl,
		'data': urlParams,
		'type': "POST",
		'success': Mediawiki.deleteArticleCallback
	});

	return true;

      } catch (e) {
	Mediawiki.error("Error deleting article");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
      }
};


Mediawiki.deleteArticleCallback = function(resultJson) {
	var result;
	try {
		eval('result = ' + resultJson + ';');
		if (Mediawiki.e(result.error)){

			Mediawiki.updateStatus("Delete Article Successful", false);
			Mediawiki.runCallback(Mediawiki.deleteArticleSuccess);

		} else {
			Mediawiki.runCallback(Mediawiki.deleteArticleFailure, "Error deleting article: " + result.error.info); 
		}


	} catch (e) {
		// Javascript Error 
		Mediawiki.error("Error during article callback");
		Mediawiki.d(Mediawiki.print_r(e));
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
Mediawiki.editArticle = function (article, callBackSuccess, callBackFailure){
     try {
	var token = Mediawiki.getToken(article.title, "edit"); 
	if (token === false){
		Mediawiki.error("Error obtaining edit token, edit failed");
		return false;
	}

	var urlParams = {
		'token' : token,	
		'action' : 'edit',
		'format' : 'json'
	};
	// Pass thru
	for (var key in article){
		urlParams[key] = article[key];
	}
		
	Mediawiki.updateStatus("Saving article...", true);
	Mediawiki.editArticleSuccess = callBackSuccess;
	Mediawiki.editArticleFailure = callBackFailure;

	Mediawiki.fetch( {
		'url': Mediawiki.apiUrl,
		'data': urlParams,
		'type': "POST",
		'success': Mediawiki.editArticleCallback
	});

	return true;

      } catch (e) {
	Mediawiki.error("Error editing article");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
      }
};				  

Mediawiki.editArticleCallback = function(resultJson) {
	var result;
	try {
		eval('result = ' + resultJson + ';');
		if (Mediawiki.e(result.error)){

			Mediawiki.updateStatus("Edit Article Successful", false);
			Mediawiki.runCallback(Mediawiki.editArticleSuccess);

		} else {
			Mediawiki.runCallback(Mediawiki.editArticleFailure, "Error saving article: " + result.error.info + " See http://www.mediawiki.org/wiki/API:Edit_-_Create%26Edit_pages" );
		}


	} catch (e) {
		// Javascript Error
		Mediawiki.error("Error during article callback");
		Mediawiki.d(Mediawiki.print_r(e));
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
	Mediawiki.updateStatus(msg, false, true);
};


/* Issue an http request, based on jQuery's ajax(). p is an object that can supply:
 * url
 * data (as an assoc array[object])
 * type (POST or GET)
 * callBack 
 * async
 * contentType (for form data. Default "application/x-www-form-urlencoded")
 * timeout how long to wait, in milliseconds, default 5000)
 *
 */
Mediawiki.fetch = function(p) {
	if (Mediawiki.e(p.type)){
		p.type = "GET";
	} else {
		p.type.toUpperCase();
	}

	if (p.type == "GET" ) {
		p.url += '?' + Mediawiki.buildQueryString(p.data);
		p.data = null;
		Mediawiki.d("Fetching " + p.url, 2);
		return jQuery.ajax(p); 
	} else {
		Mediawiki.d("POSTing data to " + p.url, 2, p.data);
		return jQuery.ajax(p);
	}
};


Mediawiki.followRedirect = function(title){
     try {
	var urlParams = {
		'action' : 'query',
		'prop' : 'info',
		'titles' : title,
		'intoken' : "edit",
		'format' : 'json',
		'redirects' : true
	};
		
	Mediawiki.d("Getting redirect...");

	var result = Mediawiki.fetch( { // Calling ajax directly because of async
		'url' : Mediawiki.apiUrl,
		'data' : urlParams,
		'type' : "POST",
		'async': false // Block for the token, since it's the first step of a multi step process
	});

	
	var responseData;
	eval ("responseData=" + result.responseText);

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
	if (Mediawiki.cookiePrefix !== null){
		// It's already been set
		return Mediawiki.cookiePrefix;
	} else {
		// Try to determine it automagically with hokey regexp. Could [should?] we query the API?
		for (var cookieName in Mediawiki.cookieMap) {
			var reg = new RegExp("([^ ;]*)" + cookieName + "=[^;]");
			var match = document.cookie.match(reg);
			if (match === null ) {
				return null;
			}
		} 
	
		// If it got this far, all the cookies were found, and match[1] contains the cookie prefix
		return match[1];
	}
};

Mediawiki.getNormalizedTitle = function(title){
	var urlParams = {
		'action' : 'query',
		'prop' : 'info',
		'titles' : title,
		'intoken' : "edit",
		'format' : 'json'
	};
		
	Mediawiki.d("Getting normalized title...");

	var result = Mediawiki.fetch( { // Calling ajax directly because of async
		'url' : Mediawiki.apiUrl,
		'data' : urlParams,
		'type' : "POST",
		'async': false // Block for the token, since it's the first step of a multi step process
	});

	
	var responseData;
	eval ("responseData=" + result.responseText);

	// We can get two different responses back here. If it's a valid title, then it returns it directly
	// If not, it returns it "normalized". If your page title isn't coming through the API, try normalizeTitle first
	if (!Mediawiki.e(responseData.query) && Mediawiki.empty(responseData.query.normalized)){
		return title;
	} else {
		return responseData.query.normalized[0]["to"];
	}
	return false;
};

Mediawiki.getToken = function(titles, tokenType){
	if (typeof titles == "array"){
		Mediawiki.error("Sorry, multiple titles not supported for getToken");
	}
	var urlParams = {
		'action' : 'query',
		'prop' : 'info',
		'titles' : titles,
		'intoken' : tokenType,
		'format' : 'json'
	};
		
	Mediawiki.d("Obtaining edit token...");

	var tokenResult = jQuery.ajax( { // Calling ajax directly because of async
		'url' : Mediawiki.apiUrl,
		'data' : urlParams,
		'type' : "POST",
		'async': false // Block for the token, since it's the first step of a multi step process
	});
	
	var responseData;
	eval ("responseData=" + tokenResult.responseText);

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
	  if (!Mediawiki.e(Mediawiki.lgusername)){
		  return Mediawiki.lgusername;
	  }

	  var cookiePrefix = Mediawiki.getCookiePrefix();
	  if (cookiePrefix === null){
		  return false;
	  } else {
		  Mediawiki.pullLoginFromCookie(cookiePrefix);
		  return Mediawiki.lgusername;
	  }	
	} catch (e) {
		Mediawiki.error("Error checking login");
		Mediawiki.d(Mediawiki.print_r(e));
		return false;
	}
};


Mediawiki.pullLoginFromCookie = function(cookiePrefix){
	for (var cookieName in Mediawiki.cookieMap) {
		var memberName = Mediawiki.cookieMap[cookieName];
		Mediawiki[memberName] = Mediawiki.cookie(cookiePrefix + cookieName);
	}
};


// http://www.mediawiki.org/wiki/API:Login
Mediawiki.login = function (callBackSuccess, callBackFailure){
	if (Mediawiki.isLoggedIn()){
		Mediawiki.d("You are already logged in");
		return; 
	}	
			
	var urlParams = {
		'action' : 'login',
		'lgname' : Mediawiki.apiUser,
		'lgpassword' : Mediawiki.apiPass,
		'format' : 'json'
	};
		
	Mediawiki.updateStatus("Logging in...", true);
	Mediawiki.loginCallbackSuccess = callBackSuccess;
	Mediawiki.loginCallbackFailure = callBackFailure;

	Mediawiki.fetch( {
		'url': Mediawiki.apiUrl,
		'data': urlParams,
		'type': "POST",
		'success': Mediawiki.loginCallback
	});
};


Mediawiki.loginCallback = function(resultJson) {
	var result;
	try {
		eval('result = ' + resultJson + ';');
		if (result.login.result == "Success"){

			Mediawiki.setLoginCookies(result.login);
			Mediawiki.updateStatus("Login Successful", false);
			Mediawiki.runCallback(Mediawiki.loginCallbackSuccess);

		} else if (result.login.result == "WrongPass" || result.login.result == "EmptyPass" || result.login.result == "WrongPluginPass"){
			Mediawiki.updateStatus("Invalid Password", false);
			Mediawiki.runCallback(Mediawiki.loginCallbackFailure, "Invalid Password");
		} else if (result.login.result == "NotExists" || result.login.result == "Illegal" || result.login.result == "NoName"){
			Mediawiki.updateStatus("Invalid Username", false);
			Mediawiki.runCallback(Mediawiki.loginCallbackFailure, "Invalid Username");
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
	// Clear the cookies and the member variables
	for (var cookieName in Mediawiki.cookieMap) {
		Mediawiki.cookie(Mediawiki.getCookiePrefix().toString() + cookieName, null);

		var memberName = Mediawiki.cookieMap[cookieName];
		Mediawiki[memberName] = null;
	}
	Mediawiki.runCallback(callbackSuccess);
	Mediawiki.updateStatus("Logout successful", false);	
};


/* Parse the selected text and return the html */
Mediawiki.parse = function (text){
	var result = Mediawiki.fetch( { // Calling ajax directly because of async
		'url' : Mediawiki.apiUrl,
		'data' : {"action": "parse", "text": text, "format": "json"},
		'type' : "POST",
		'async': false // No callback, this should be fast 
	});

	
	var responseData;
	eval ("responseData=" + result.responseText);

	if (Mediawiki.e(responseData.parse) || Mediawiki.e(responseData.parse.text)){
		return false;
	} else {
		return responseData.parse.text['*'];
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
Mediawiki.pullArticleContent = function (title, callBack, options){
	var urlParams = {
		'action' :'query',
		'titles' : title,
		'prop' : 'revisions',
		'rvprop' : 'content',
		'format' : 'json'
	};
	
	if (typeof options == "object") {
		// Pass thru
		for (var option in options){
			urlParams[option] = options[option];
		}
	}
	
	// Store the callback	
	Mediawiki.pullArticleCallback = callBack;

	Mediawiki.fetch({
		'url' : Mediawiki.apiUrl,
		'data' : urlParams,
		'success': Mediawiki.pullArticleContentCallback
	});
};


Mediawiki.pullArticleContentCallback = function (resultJson) {
	var result;
	try {
		eval('result = ' + resultJson + ';');
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
			} else {
				Mediawiki.updateStatus("Pull Article Successful", false);
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
Mediawiki.pullArticleHtml = function (title, callBack){
	var urlParams = {
		'action' :'render',
		'title' : title
	};
	
	Mediawiki.fetch({
		'url' : Mediawiki.apiUrl.replace(/api.php/, 'index.php'),
		'data' : urlParams,
		'success': callBack
	});
};


Mediawiki.runCallback = function(callBack, arg){
	var parens = "()";
	if (typeof arg != "undefined") {
		parens = '(arg)';
	}
	if (typeof callBack == "string" && typeof window[callBack] == "function"){
		return eval(callBack + parens + ";");
	} else if (typeof callBack == "function"){
		var anonFunc = callBack;
		return eval("anonFunc" + parens + ";");
	}
};


Mediawiki.setLoginCookies = function(vars) {
      try {
	Mediawiki.lguserid = vars.lguserid;
	Mediawiki.lgusername = vars.lgusername;
	Mediawiki.sessionid = vars.sessionid;
	Mediawiki.lgtoken = vars.lgtoken;
	Mediawiki.cookieprefix = vars.cookieprefix;

	var cp = Mediawiki.getCookiePrefix() || "";

	for (var cookieName in Mediawiki.cookieMap) {
		var memberName = Mediawiki.cookieMap[cookieName];
		Mediawiki.cookie(cp + cookieName, Mediawiki[memberName], Mediawiki.sessionLength);
	}

	return true;

      } catch (e) {
	Mediawiki.error("Error setting login cookies");
	Mediawiki.d(Mediawiki.print_r(e));
	return false;
      }
};


Mediawiki.updateStatus = function(msg, waiting, isError){

	if (Mediawiki.statusBar === null) {
		Mediawiki.statusBar = new MediawikiStatusBar();
	}

	if ( isError ){
		document.body.style.cursor = "default";
		Mediawiki.statusBar.show(msg, null, true);
	} else if (waiting ){
		document.body.style.cursor = "wait";
		Mediawiki.statusBar.show(msg, 30000, false);
	} else {
		document.body.style.cursor = "default";
		Mediawiki.statusBar.show(msg, 3000, false);
	}
};

var MediawikiStatusBar = function (sel,options) {
	var _I = this;	     
	var _sb = null;
	
	// options     
	this.elementId = "_showstatus";
	this.prependMultiline = true;	
	this.showCloseButton = true; 
	this.afterTimeoutText = null;
	this.closeTimeout = 5000;

	this.cssClass = "statusbar";
	this.highlightClass = "statusbarhighlight";
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
		
		_sb.fadeIn("slow");	   
		
		if (timeout) {
			if (isError) {
			    _sb.addClass(_I.errorClass);
			} else {
			    _sb.addClass(_I.highlightClass);
			}
			    
			window.setTimeout( function() {
				_sb.removeClass(_I.highlightClass); 
				if (_I.afterTimeoutText) {
					_I.show(_I.afterTimeoutText);
				}
			     },
			     timeout);
		} else {
			timeout = 0;
		} 
		window.setTimeout( function(){
			_I.release();
			}, _I.closeTimeout + timeout); 
			
	}; 

	this.release = function() {
		if(Mediawiki.statusBar) {
			$(_sb).fadeOut("slow");
		}
	};	
};
