var config = require("./server_config.js");
var redis = require('redis');
var rc = redis.createClient(config.REDIS_PORT, config.REDIS_HOST);
var request = require('request');

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

var requestMW = function(roomId, query, callback, errorcallback) {
	if(!errorcallback){
		errorcallback = function() {};
	}
	
	console.log("Trying to find the wgServer for the room key: " + config.getKey_room( roomId ));
	rc.hget(config.getKey_room( roomId ), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error getting wgServer for a room: ' + err); 
			errorcallback();
		} else if (data) {
			var wikiHostname = data.replace(/^https?:\/\//i, "");
			var url = 'http://' + wikiHostname + '/index.php' + query + "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching this (at least on dev boxes) when we don't want it to... so cachebust it.;
			console.log("Making  request to host: " + url);
			request({
			    	method: 'GET',
			    	//followRedirect: false,
			    	url: url,
			    	proxy: 'http://' + config.WIKIA_PROXY_HOST + ':' + config.WIKIA_PROXY_PORT
			    }, 
			    function (error, response, body) {
			    	if(error) {
			    		errorcallback();
			    		console.log(error);	
			    		return ;
			    	}
			    	
			    	if(response.statusCode ==  200) {
						try{
							data = JSON.parse(body);
							callback(data);
						} catch(e) {
							console.log("Error: while parsing result. Error was: ");
							console.log(e);
							console.log("Response that didn't parse was:\n" + body);
		
							data = {
								error: '',
								errorWfMsg: 'chat-err-communicating-with-mediawiki',
								errorMsgParams: []
							};
						}
			    		console.log(data);
			    	}
			    }
			);
		}
	});
}
	

var getUrl = function(method, params) {
	var base = "/?action=ajax&rs=ChatAjax&method=" + method + "&";
	
	for(var key in params) {
		base = base + key + "=" + params[key] + "&";
	}
	
	return base;
};

var WMBridge = function() {
//	var KICKBAN_URL = "/?action=ajax&rs=ChatAjax&method=kickBan";
//	var GIVECHATMOD_URL = "/?action=ajax&rs=ChatAjax&method=giveChatMod";
}


WMBridge.prototype.getUser = function(roomId, name, key, success, error) {
	var requestUrl = getUrl('getUserInfo', {
		roomId: roomId,
		name: urlencode(name),
		key: key
	});
	
	console.log(requestUrl);
	
	requestMW(roomId, requestUrl, success, error);
}

console.log(WMBridge.prototype.getUser);

exports.WMBridge = new WMBridge();