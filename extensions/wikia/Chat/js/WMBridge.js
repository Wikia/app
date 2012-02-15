

var WMBridge = function() {
	var KICKBAN_URL = "/?action=ajax&rs=ChatAjax&method=kickBan";
	var GIVECHATMOD_URL = "/?action=ajax&rs=ChatAjax&method=giveChatMod";
	
	var getUrl = function(method, params) {
		var base = "/?action=ajax&rs=ChatAjax&method=" + method + "&";
		
		for(var key in params) {
			base = base + key + "=" + params[key];
		}
		
		return base;
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
}


WMBridge.prototype.getUser = function(name, roomId, key, success, error) {
	var requestUrl = getUrl('getUserInfo', {
		roomId: roomId,
		name: urlencode(name),
		key: key
	});
	
	requestMW(roomId, requestUrl, success, callback, error);
}



exports.WMBridge = new WMBridge();