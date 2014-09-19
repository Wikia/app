var monitoring = require('./monitoring.js');
var config = require("./server_config.js");
var qs = require('qs'); 
var storage = require('./storage').redisFactory();
var request = require('request');
var logger = require('./logger').logger;
var url = require('url');

var urlencode = function(str) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: AJ
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Lars Fischer
    // +      input by: Ratheous
    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Joris
    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
    // %          note 1: This reflects PHP 5.3/6.0+ behavior
    // %        note 2: Please be aware that this function expects to encode into UTF-8 encoded strings, as found on
    // %        note 2: pages served as UTF-8
    // *     example 1: urlencode('Kevin van Zonneveld!');
    // *     returns 1: 'Kevin+van+Zonneveld%21'
    // *     example 2: urlencode('http://kevin.vanzonneveld.net/');
    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
    // *     example 3: urlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
    str = (str + '').toString();

    // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
    // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
    replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
};

var requestMW = function(method, roomId, postdata, query, handshake, callback, errorcallback) {
	if(!errorcallback){
		errorcallback = function() {};
	}
	
	if(typeof postdata == "object" && method == 'POST' ) {
		logger.debug(postdata);
		postdata = qs.stringify(postdata);
		logger.debug(postdata);
	} else {
		postdata = "";
	}

	storage.getRoomData(roomId, 'wgServer', function(server) {
		if (server) {
			var wikiHostname = server.replace(/^https?:\/\//i, ''),
				redirectInfo = {
					redirects: 0,   // number of redirects followed so far
					MAX_REDIRECTS: 3,   // maximum number of redirects
					newServer: null   // last redirect host (http(s)://something)
				},
				// settings HTTP headers' variable
				headers = {
					'content-type': 'application/x-www-form-urlencoded'
				};

			if( handshake && handshake.headers ) {
				if( typeof handshake.headers['user-agent'] !== 'undefined' ) {
					headers['user-agent'] = handshake.headers['user-agent'];
				}

				if( typeof handshake.headers['x-forwarded-for'] !== 'undefined' ) {
					headers['x-forwarded-for'] = handshake.headers['x-forwarded-for'];
				}
			}

			/**
			 * check the response and if this is a redirect to a new server, follow it
			 * returns true in case the method handled the redirect response
			 */
			function handleRedirect(response) {
				if (response && (response.statusCode ==  301) && response.headers && response.headers.location) {
					// extract server
					var parts = url.parse(response.headers.location);
					if (parts.hostname != wikiHostname) {
						redirectInfo.redirects++;
						if (redirectInfo.redirects < redirectInfo.MAX_REDIRECTS) {
							redirectInfo.newServer = parts.protocol + '//' + parts.hostname;
							makeRequest(parts.hostname);
							return true;
						}
					}
				}
				return false;
			}

			/**
			 * if we were redirected to a new server, store its address in redis
			 */
			function updateMWaddress() {
				if (redirectInfo.newServer && (server != redirectInfo.newServer)) {
					logger.critical('Old wiki address found: ' + server + ', updating to ' + redirectInfo.newServer);
					storage.setRoomData(roomId, 'wgServer', redirectInfo.newServer);
				}
			}

			/**
			 * Make a request to MW host entrypoint
			 */
			function makeRequest(host) {
				var requestUrl = 'http://' + host + '/index.php' + query + "&cb=" + Math.floor(Math.random()*99999), // varnish appears to be caching this (at least on dev boxes) when we don't want it to... so cachebust it.;
					data;
				logger.debug("Making request to host: " + requestUrl);
				request({
						method: method,
						//followRedirect: false,
						headers: headers,
						body: postdata,
						json: false,
						url: requestUrl,
						proxy: 'http://' + config.WIKIA_PROXY
					},
					function (error, response, body) {
						if (handleRedirect(response)) { // cross-server 301 handling
							return;
						}
						if(error) {
							errorcallback();
							logger.error(error);
							return ;
						}
						logger.debug(response.statusCode);
						if(response.statusCode ==  200) {
							try{
								if((typeof body) == 'string'){
									data = JSON.parse(body);
									logger.debug("parsing");
								} else {
									logger.debug("parsed by request");
									data = body;
								}
								logger.debug(data);
								updateMWaddress();
								callback(data);
							} catch(e) {
								logger.error("Error: while parsing result from:" + requestUrl + '\nError was' + e.message + "\nResponse that didn't parse was:" );
								logger.error(body);
								data = {
									error: '',
									errorWfMsg: 'chat-err-communicating-with-mediawiki',
									errorMsgParams: []
								};
							}
							logger.debug(data);
						}
				});
			}

			makeRequest(wikiHostname);
		}
	},
	errorcallback);
};


var getUrl = function(method, params) {
	var base = "/?action=ajax&rs=ChatAjax&method=" + method + "&";
	
	for(var key in params) {
		base = base + key + "=" + params[key] + "&";
	}
	
	return base;
};

var WMBridge = function() {
//	var BAN_URL = "/?action=ajax&rs=ChatAjax&method=ban";
//	var GIVECHATMOD_URL = "/?action=ajax&rs=ChatAjax&method=giveChatMod";
}

                                
var authenticateUserCache = {};

var clearAuthenticateCache = function(roomId, name) {
	var cacheKey = name + "_" + roomId;
        if(authenticateUserCache[cacheKey]) {
		delete authenticateUserCache[cacheKey];
	}
}

WMBridge.prototype.authenticateUser = function(roomId, name, key, handshake, success, error) {
        var cacheKey = name + "_" + roomId;
        if(authenticateUserCache[cacheKey] && authenticateUserCache[cacheKey].key == key ) {
                return success(authenticateUserCache[cacheKey].data);
        }

        var requestUrl = getUrl( 'getUserInfo', {
                roomId: roomId,
                name: urlencode(name),
                key: key
        });
        
        logger.debug(requestUrl);
		var ts = Math.round((new Date()).getTime() / 1000);
		monitoring.incrEventCounter('authenticateUserRequest');
		requestMW( 'GET', roomId, {}, requestUrl, handshake, function(data) {
			authenticateUserCache[cacheKey] = {
				data: data,
				key: key,
				ts: ts
			};
			success(data);
		}, error );
}

setInterval(function() {
	var ts = Math.round((new Date()).getTime() / 1000);
	for (i in authenticateUserCache){
		if((ts - authenticateUserCache[i].ts) > 60*15) {
			delete authenticateUserCache[i];
		}
	}
}, 5000);

WMBridge.prototype.ban = function(roomId, name, handshake ,time, reason, key, success, error) {
	clearAuthenticateCache(roomId, name);
	var requestUrl = getUrl('blockOrBanChat', {
		roomId: roomId,
		userToBan: urlencode(name),
		time: urlencode(time),
		reason: urlencode(reason),
		mode: 'global',
		key: key,
		userIP: (handshake.address && handshake.address.address) || ''
	});

	requestMW('GET', roomId, {}, requestUrl, handshake, function(data){
		// Process response from MediaWiki server and then kick the user from all clients.
		if(data.error || data.errorWfMsg){
			error(data);
		} else {
			success(data);
		}
	});
}


WMBridge.prototype.giveChatMod = function(roomId, name, handshake, key, success, error) {
	clearAuthenticateCache(roomId, name);
	var requestUrl = getUrl('giveChatMod', {
		roomId: roomId,
		userToPromote: urlencode(name),
		key: key,
		userIP: (handshake.address && handshake.address.address) || ''
	});

	requestMW('GET', roomId, {}, requestUrl, handshake, function(data){
		// Process response from MediaWiki server and then kick the user from all clients.
		if(data.error || data.errorWfMsg){
			error(data);
		} else {
			success(data);
		}
	});
};

var setUsersList = function(roomId, users) {
	monitoring.incrEventCounter('broadcastUserList');
        var requestUrl = getUrl('setUsersList', {
                roomId: roomId,
                token: config.TOKEN
        });

        var userToSend = [];

        for(var userName in users) {
                userToSend.push(userName);
        }

        requestMW('POST', roomId, {users: userToSend}, requestUrl, null, function(data){

        });
}

var setUsersListQueue = {};

WMBridge.prototype.setUsersList = function(roomId, users) {
	setUsersListQueue[roomId] = users;
}


setInterval(function() {
        for (i in setUsersListQueue){
	        setUsersList(i, setUsersListQueue[i]);
		delete setUsersListQueue[i];
        }
}, 10000);


exports.WMBridge = new WMBridge();
