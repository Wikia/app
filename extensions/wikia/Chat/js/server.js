
/** REQUIRES, OTHER SETUP **/
	
var app = require('express').createServer()
    , jade = require('jade')
    , sio = require('./lib/socket.io.js')
    , _ = require('underscore')._
    , Backbone = require('backbone')
    , redis = require('redis')
    , rc = redis.createClient()
    , models = require('./models/models')
	, urlUtil = require('url');
var http = require("http");
var config = require("./server_config.js");
var emoticons = require("./server_emoticons.js");


//console.log = function() {};

console.error = function(err) {
        console.log('Error ' + err);
        node.exit();
};

rc.on('error', function(err) {
        console.log('Error ' + err);
        node.exit();
});

// TODO: Consider using this to catch uncaught exceptions (and then exit anyway):
//process.on('uncaughtException', function (err) {
//  console.log('Caught exception: ' + err);
//  console.log('Stacktrace: ');
//	console.log(err.stack);
//	console.log('Full, raw error: ');
//	console.log(err);
//	// TODO: is there some way to email us here (if on production) so that we know the server crashed?
//	process.exit(1);
//});



/** DONE WITH CONFIGS & REQUIRES... BELOW IS THE ACTUAL APP CODE! **/

// This includes and starts the API server (which MediaWiki makes requests to).
console.log("== Starting the API Server ==");
require("./server_api.js");

// Start the Node Chat server (which browsers connect to).
console.log("== Starting Node Chat Server ==");

//configure express to use jade
app.set('view engine', 'jade');
app.set('view options', {layout: false});

//setup routes
app.get('/*.(js|css)', function(req, res){
    res.sendfile('./'+req.url);
});

app.get('/', function(req, res){
    res.render('index');
});

// TODO: MUST REMOVE THIS WHEN WE HAVE MULTIPLE NODE SERVERS! (and figure out another solution to prune entries who are no longer connected... perhaps prune any time you try to send to them & they're not there?).
console.log("Pruning old room memberships...");
rc.keys( config.getKeyPrefix_usersInRoom()+":*", function(err, data){
	if(err){
		console.log("Error: while trying to get all room membership lists. Error msg: " + err);
	} else {
		_.each(data, function(usersInRoomKey) {
			console.log("\tCleaning users out of room with key: " + usersInRoomKey);
			rc.del(usersInRoomKey, redis.print);
		});
	}
});
console.log("Rooms cleaned.");

// Load default emoticon mapping (will be the mapping for all wikis which don't have MediaWiki:Emoticons set.
var defaultEmoticonMapping = new EmoticonMapping();
defaultEmoticonMapping.loadDefault();
console.log("Loading the default emoticon mapping from Messaging Wiki...");
var httpClient = http.createClient(config.WIKIA_PROXY_PORT, config.WIKIA_PROXY_HOST);
getWikiText(httpClient, config.MESSAGING_WIKI_HOSTNAME, emoticons.EMOTICON_ARTICLE, function(wikiText){
	defaultEmoticonMapping.loadFromWikiText( wikiText );
	console.log("Done loading default emoticons from MessagingWiki.");
});

//Start the main chat server listening.
app.listen(config.CHAT_SERVER_PORT, function () {
	var addr = app.address();
	console.log('   app listening on http://' + addr.address + ':' + addr.port);
});


var io = sio.listen(app);

console.log("Updating runtime stats");

rc.hgetall(config.getKey_runtimeStats(), function(err, data){
	var started = parseInt(new Date().getTime());
	if(err) {
		console.log("Error getting runtime stats:");
		console.log(err);
	} else {
		if(!data) {
			var data = {
					laststart : started, 
					startcount: 0,
					runtime: 0 
			};
		} else {
			data.startcount++;
			data.runtime = parseInt(data.runtime) + started - parseInt(data.laststart); 
			data.laststart = started;
		}
		console.log(data);
		rc.hmset(config.getKey_runtimeStats(), data , function(err) {
			if(err) {
				console.log(err);
			}
		});
	}
	startServer();
});


//create local state
var sessionIdsByKey = {}; // for each room/username combo, store the sessionId so that we can send targeted messages.
io.configure(function () {
	io.set('transports', [   'websocket', 'flashsocket', 'htmlfile', 'xhr-polling', 'jsonp-polling'  ]);
});

function startServer() {
	console.log("Chat server running on port " + config.CHAT_SERVER_PORT);

	rc.hset(config.getKey_userCount(), 'count', 0, function(err, data) {});
	
	io.sockets.on('connection', function(client){
		client.isAuthenticated = false;
		rc.hincrby(config.getKey_userCount(), 'count', 1, function(err, data) {});
		// On initial connection, just wait around for the client to send it's authentication info.
		client.on('message', function(msg){
			messageDispatcher(client, io.sockets, msg)}
		);

		client.on('disconnect', function(){
			rc.hincrby(config.getKey_userCount(), 'count', -1,function(err, data) {});
			clientDisconnect(client, io.sockets);
		});

		client.sessionId = client.id; //for 0.6 
		// Send a message to the client to cause it to send it's authentication info back to the server.

		client.json.send({
			event: 'auth'
	    });

		console.log("Raw connection recieved. Waiting for authentication info from client.");
	});
}

/**
 * Bound to the 'message' event, gets any message from the client. If the user
 * is not authenticated, this won't listen to anything other than authentications.
 */
function messageDispatcher(client, socket, data){
	console.log(data);
	if( ! client.isAuthenticated ){
		console.log("Dispatching to authConnection.");
		authConnection(client, socket, data)
	} else {
		// The user is authed. Check to make sure their client sessionId still exists. If it doesn't, we probably banned them.
		var sessionId = false;
		if(typeof client.myUser != 'undefined' && typeof client.myUser.get != 'undefined'){
				var sessionId = sessionIdsByKey[config.getKey_userInRoom(client.myUser.get('name'), client.roomId)];
		}
		if(sessionId === false || (typeof sessionId == "undefined") || (sessionId != client.sessionId)){
			client.json.send({
					event: 'forceReconnect'
			});
			// Message ignored. Log the reason.
			if(sessionId === false || typeof sessionId == "undefined"){
					console.log("GOT A MESSAGE WITH NO socket.io sessionId. ASSUMING THEY ARE BANNED AND SKIPPING.");
			} else if(sessionId != client.sessionId){
					var msg = "Got a message from a user with a mismatched client-id. This implies that the user sending the message ";
					msg += "(" + client.myUser.get('name');
					msg += ") has connected from a newer browser and the old browser which sent the message has been closed ";
					msg += "and is in the process of having its connection closed.";
					console.log(msg);
			}
		} else {
			// The user is authenticated.  Dispatch to appropriate place for the message.
			var dataObj;
			try{
				dataObj = JSON.parse(data);
			} catch(e){
				dataObj = {};
				console.log("Error: while parsing raw incoming json (to msg dispatcher). Error was: ");
				console.log(e);
				console.log("JSON-string that didn't parse was:\n" + data);
			}
			if(typeof dataObj.attrs == 'undefined'){
				dataObj.attrs = {};
			}
			if(typeof dataObj.attrs.msgType == 'undefined'){
				dataObj.attrs.msgType = "[msgType was undefined]";
			}
			switch(dataObj.attrs.msgType){
				case 'chat':
					console.log("Dispatching to message handler.");
					chatMessage(client, socket, data);
					break;
				case 'command':
					switch(dataObj.attrs.command){ // all commands should be in lowercase
						case 'kickban':
							console.log("Kickbanning user: " + dataObj.attrs.userToBan);
							kickBan(client, socket, data);
							break;
						case 'openprivate':
							console.log( "openPrivateRoom" );
							openPrivateRoom(client, socket, data);
							break;
						case 'givechatmod':
							console.log("Giving chatmoderator status to user: " + dataObj.attrs.userToPromote);
							giveChatMod(client, socket, data);
							break;
						case 'setstatus':
							console.log("Setting status for " + client.myUser.get('name') + " to " + dataObj.attrs.statusState + " with message '" + dataObj.attrs.statusMessage + "'.");
							setStatus(client, socket, data);
							break;
						default:
							console.log("Unrecognized command: " + dataObj.attrs.command);
						break;
					}
					break;
				default:
					console.log("ERROR: Could not find recognized msgType to handle data: ");
					console.log(data);
					break;
			}
		}
	}
} // end messageDispatcher()


/**
 *  open private chat with other users 
 */

function openPrivateRoom(client, socket, data){
	var roomInfo = new models.OpenPrivateRoom();	
	roomInfo.mport(data);
	
	rc.hkeys( config.getKey_usersAllowedInPrivRoom( roomInfo.get('roomId') ),  function(err, users){
		var privateRoom = new models.OpenPrivateRoom( { roomId : roomInfo.get('roomId'), users: users } );
		broadcastToRoom(client, socket, {
			event: 'openPrivateRoom',
			data: privateRoom.xport()
		}, users);
	});
}

/**
 * After the initial connection, the client will be expected to send its auth
 * info (essentially: the Wikia authentication cookies) so that we can then
 * use this info to verify with the Wikia apaches that the user is connected
 * and what their rights are.
 *
 * The authData should also contain two keys: 'cookie' and 'roomId', the roomId
 * of the room the user is trying to enter (must be on the wiki which they are
 * chatting on - this guarantees that the permissions checks for the room's wiki
 * are used - since users could be banned on one wiki and not another).
 */
function authConnection(client, socket, authData){
	var authJson = JSON.parse( authData );
	var auth = new models.AuthInfo( authJson.attrs );
	if(typeof  authJson.attrs != "undefined"){
		auth.set(authJson.attrs);
	}
	console.log("Authentication info recieved from client. Verifying with Wikia MediaWiki app server...");
	
	// Need to auth with the correct wiki. Lookup the hostname for the chat in redis.
	console.log("Trying to find the wgServer for the room key: " + config.getKey_room( auth.get('roomId') ));
	rc.hget(config.getKey_room( auth.get('roomId') ), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error getting wgServer for a room: ' + err);
		} else if (data) {
			console.log("Got wgServer in data: " + data);
			var wikiHostname = data.replace(/^https?:\/\//i, "");
			console.log("Making getUserInfo request to host: " + wikiHostname);

			// Format the cookie-data into the correct string for sending the data as a header.
			var roomId = auth.get('roomId');

			console.log("Auth data for client w/sessionId '" + client.sessionId + "': " + auth.get('key') );
			client.authKey = auth.get('key');
			
			// Send auth cookies to apache to make sure this user is authorized & get the user information.
			
			client.userKey = auth.get('key');
			
			var requestHeaders = {
				'Host': wikiHostname
			};

			var requestUrl = config.AUTH_URL + "&roomId=" + roomId ;	
			requestUrl +=  "&name=" + encodeURIComponent(auth.get('name'));
			requestUrl +=  "&key=" + client.userKey ;
			requestUrl += "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching this (at least on dev boxes) when we don't want it to... so cachebust it.

			console.log("Requesting user info from: " + requestUrl);

			// NOTE: Swap back if we want to use a proxy again.
			var httpClient = http.createClient(config.WIKIA_PROXY_PORT, config.WIKIA_PROXY_HOST);
			//var httpClient = http.createClient(80, wikiHostname); // TODO: Swap this in for ALL INSTANCES of createClient if we don't want to use local proxy anymore.
			
			var callback = function(data) {
				if( (data.canChat) && (data.isLoggedIn) && data.username == auth.get('name') ){
					rc.hkeys( config.getKey_usersAllowedInPrivRoom( auth.get('roomId') ),  function(err, users){
						if(users.length == 0 || _.indexOf(users, data.username) !== -1 ) { //
							client.isAuthenticated = true;
							client.isChatMod = data.isChatMod;
							client.isCanGiveChatMode = data.isCanGiveChatMode;
							client.isStaff = data.isStaff;
							client.roomId = roomId;
							
							// TODO: REFACTOR THIS TO TAKE ANY FIELDS THAT data GIVES IT.
							client.ATTEMPTED_NAME = data.username;
							
							// User has been approved & their data has been set on the client. Put them into the chat.
	
							// TODO: REFACTOR THESE TO USE THE VALUE STORED IN THE 'chat' OBJ IN REDIS (remove the setting of these client vars from the ajax request also).
							// Extra wg variables that we'll need.
							client.wgServer = data.wgServer;
							client.wgArticlePath = data.wgArticlePath;
							// TODO: REFACTOR THESE TO USE THE VALUE STORED IN THE 'chat' OBJ IN REDIS (remove the setting of these client vars from the ajax request also).
	
							// BugzId 5752 - clear chat buffer if this is the first user in the room (to avoid confusion w/past chats).
							rc.hlen(config.getKey_usersInRoom(client.roomId), function(err, numInRoom){
								if (err) {
									console.log('Error: while trying to find number of people in room "' + client.roomId + '": ' + err);
								} else if((numInRoom) && (numInRoom > 0)){
									finishConnectingUser(client, socket, data);
								} else {
									// Nobody is in the room yet, so clear the back-buffer before doing the rest of the setup (as per BugzId 5752).
									console.log(data.username + " is the first person to re-enter a now-empty room " + client.roomId + ".");
									console.log("Deleting the back-buffer before connecting them the rest of the way.");
	
									rc.del(config.getKey_chatEntriesInRoom(client.roomId), function(err, delData){
										finishConnectingUser(client, socket, data);
									});
								}
							});

							// Asynchronously load the emoticon settings for this wiki, into the client object that just connected.
							// PERFORMANCE NOTE: We could cache the emoticonMapping per-wiki in redis for a certain amount of time but we'd have to worry about purging or reasonable expiration.
							// Currently, we just rely on the fact that Varnish will cache the API result (which will then be purged if there are updates).
							console.log("Starting request to get emoticons for '" + data.username + "'...");
							getWikiText(httpClient, wikiHostname, emoticons.EMOTICON_ARTICLE, function(wikiText){
								if(wikiText != ""){
									client.emoticonMapping = new EmoticonMapping();
									client.emoticonMapping.loadFromWikiText( wikiText );
									console.log("Done getting emoticons for '" + data.username + "'.");
								}
							});

						} else {
							console.log("User try to conect with someone else private room");
							//it is hack attempts no meesage for this
						}});
				} else {
					console.log("User failed authentication. Error from server was: " + data.errorMsg);
					sendInlineAlertToClient(client, data.error, data.errorWfMsg, data.errorMsgParams);
					console.log("Entire data was: ");
					console.log(data);
				}
			};
			
			
			if(typeof(data.isLoggedIn) != 'undefined') {
				callback(data);
			} else {
				var httpRequest = httpClient.request("GET", requestUrl, requestHeaders);
				httpRequest.addListener("response", function (response) {
					//debugObject(client.request.headers);
					var responseBody = "";
					//response.setBodyEncoding("utf8");
					response.addListener("data", function(chunk) {
						responseBody += chunk;
					});
					response.addListener("end", function() {
						try{
							data = JSON.parse(responseBody);
						} catch(e){
							console.log("Error: while parsing result of getUserInfo(). Error was: ");
							console.log(e);
							console.log("Response that didn't parse was:\n" + responseBody);

							data = {
								error: '',
								errorWfMsg: 'chat-err-communicating-with-mediawiki',
								errorMsgParams: []
							};
						}
						
						rc.hmset(config.getKey_sessionData( client.userKey ), data, function() {});
						
						console.log("=============Session data================");
						console.log(data);
						console.log("=============/Session data================");
						
						callback(data);
					});
				});
				httpRequest.end();
			}
			console.log("=============Session data from cache================");
			console.log(data);
			console.log("=============/Session data from cache================");
		} else {
			console.log("Didn't get data for the roomId so it probably doesn't exist anymore: " + auth.get('roomId'));
		}
	}); // end of block for getting wgServer from the room's hash in redis.
	console.log("Started request to get wgServer from redis");
} // end of socket connection code


/**
 * This is called after the result from the MediaWiki server has set up this client's user-info.
 * This adds the user to the room in redis and sends the initial state to the client.
 */
function finishConnectingUser(client, socket, rawUserInfo){
	console.log(new Date().getTime());
	var nodeChatModel = new models.NodeChatModel();
	rc.lrange(config.getKey_chatEntriesInRoom(client.roomId), (-1 * config.NUM_MESSAGES_TO_SHOW_ON_CONNECT), -1, function(err, data) {
		console.log(new Date().getTime());
		if (err) {
			console.log('Error: ' + err);
		} else if (data) {
			_.each(data, function(jsonChat) {
				var chatEntry = new models.ChatEntry();
				chatEntry.mport(jsonChat);
				nodeChatModel.chats.add(chatEntry);
			});

			console.log('Revived ' + nodeChatModel.chats.length + ' chats');
		} else {
			console.log('No data returned for key');
		}

		// Load the initial userList
		console.log("Finding members of roomId " + client.roomId);

		rc.hgetall(config.getKey_usersInRoom( client.roomId ), function(err, usernameToData){
			if (err) {
				console.log('Error: while trying to find members of room "' + client.roomId + '": ' + err);
			} else if(usernameToData){
				_.each(usernameToData, function(userData){
					var userModel = new models.User( JSON.parse(userData) );
					//console.log("Room member of " + client.roomId + ": ");
					//console.log(userModel);
					nodeChatModel.users.add(userModel);
				});
			}

			// Send this whole model to the newly-connected user.
			//console.log("SENDING INITIAL STATE...");
			//console.log(nodeChatModel.xport());
			client.json.send({
				event: 'initial',
				data: nodeChatModel.xport()
			});
			
			// Initial connection of the user (unless they're already connected).
			var connectedUser = nodeChatModel.users.find(function(user){return user.get('name') == rawUserInfo.username;});
			if(!connectedUser) {
			connectedUser = new models.User({
					name: rawUserInfo.username,
					avatarSrc: rawUserInfo.avatarSrc,
					isModerator: client.isChatMod,
					isCanGiveChatMode: client.isCanGiveChatMode,
					isStaff: client.isStaff,
					editCount: rawUserInfo.editCount,
					since: rawUserInfo.since
				});
			
				nodeChatModel.users.add(connectedUser);
				console.log('[getConnectedUser] new user: ' + connectedUser.get('name') + ' on client: ' + client.sessionId);
			}
			client.myUser = connectedUser;
			
			if( client.ATTEMPTED_NAME != client.myUser.get('name') ){
				console.log("\t\t============== POSSIBLE IDENTITY PROBLEM!!!!!! - BEG ==============");
				console.log("\t\tATTEMPTED NAME:     " + client.ATTEMPTED_NAME + " (probably the correct name)");
				console.log("\t\tATTACHED TO USR:    " + client.myUser.get('name'));
				console.log("\t\tAFTER MATCHING FOR: " + rawUserInfo.username);
				console.log("\t\t============== POSSIBLE IDENTITY PROBLEM!!!!!! - END ==============");
			}

			// If this same user is already in the sessionIdsByKey hash, then they must be connected in
			// another browser. Kick that other instance before continuing (multiple instances cause all kinds of weirdness.
			var existingId = sessionIdsByKey[config.getKey_userInRoom(client.myUser.get('name'), client.roomId)];
			if(typeof existingId != "undefined"){
				// Send the old client a notice that they're about to be disconnected and why.
				var oldClient = socket.socket(existingId);
				sendInlineAlertToClient(oldClient, '', 'chat-err-connected-from-another-browser', [], function(){
					// Looks like we're kicking ourself, but since we're not in the sessionIdsByKey map yet,
					// this will only kick the other instance of this same user connected to the room.
					kickUserFromRoom(oldClient, socket, client.myUser, client.roomId, function(){
						// This needs to be done after the user is removed from the room.  Since clientDisconnect() is called asynchronously,
						// the user is explicitly removed from the room first, then clientDisconnect() is prevented from attempting to remove
						// the user (since that may get called at some point after formallyAddClient() adds the user intentionally).
						formallyAddClient(client, socket, connectedUser);
					});
				});
			} else {
				// Put the user info into the room hash in redis, and add the client to the in-memory (not redis) hash of connected sockets.
				formallyAddClient(client, socket, connectedUser);
			}
		});
	});
} // end finishConnectingUser()

/**
 * Adds the client to their room in redis and adds their sessionId to the hash of sessionIdsByKey.
 *
 * This should only be done after any duplicates of this user have been ejected from the room already (in the case
 * of the same user connecting from multiple browsers).
 */
function formallyAddClient(client, socket, connectedUser){
	// Add the user to the set of users in the room in redis.
	var hashOfUsersKey = config.getKey_usersInRoom(client.roomId);
	var userData = client.myUser.attributes;
	delete userData.id;

	sessionIdsByKey[config.getKey_userInRoom(client.myUser.get('name'), client.roomId)] = client.sessionId;
	rc.hset(hashOfUsersKey, client.myUser.get('name'), JSON.stringify(userData), function(err, data){
		// Broadcast the join to all clients.
		console.log(new Date().getTime());
		broadcastToRoom(client, socket, {
			event: 'join',
			joinData: connectedUser.xport()
		});
	});
} // end formallyAddClient()

/**
 * Called when a client disconnects from the server.
 *
 * If client has property 'doNotRemoveFromRedis' set to true, then the user will be removed from the room hash in redis (this is used
 * sometimes to prevent race conditions).
 */
function clientDisconnect(client, socket) {
	// Remove the in-memory mapping of this user in this room to their sessionId
	if(typeof client.myUser != 'undefined' && typeof client.myUser.get != 'undefined'){
		delete sessionIdsByKey[config.getKey_userInRoom(client.myUser.get('name'), client.roomId)];
	}

	// Remove the user from the set of usernames in the current room (in redis).
	if(client.doNotRemoveFromRedis){
//		console.log("Not removing user from room, just broadcasting their part & the associated inline alert for " + client.myUser.get('name'));
		broadcastDisconnectionInfo(client, socket);
	} else if(typeof client.myUser != 'undefined' && typeof client.myUser.get != 'undefined'){
		console.log("Disconnected: " + client.myUser.get('name') + " and about to remove them from the room in redis & broadcast the part and InlineAlert...");
		var hashOfUsersKey = config.getKey_usersInRoom(client.roomId);
		rc.hdel(hashOfUsersKey, client.myUser.get('name'), function(err, data){
			if (err) {
				console.log('Error: while trying to remove user "' + client.myUser.get('name') + '" from room "' + client.roomId + '": ' + err);
			} else {
				broadcastDisconnectionInfo(client, socket);
			}
		});
	}
} // end clientDisconnect()

/**
 * After a client has been disconnected, broadcast the part and the associated inline-alert to all remaining members of the room.
 */
function broadcastDisconnectionInfo(client, socket){
	// Delay before sending part messages because there are occasional disconnects/reconnects or just ppl refreshing their browser
	// and that's really not useful information to anyone that under-the-hood they were disconnected for a moment (BugzId 5753).
	var DELAY_MILLIS = 7000;
	setTimeout(function(){
		// Now that the delay has passed, check that the user is still gone (if they're disconnecting/reconnecting, don't bother showing the part-message).
		rc.hget(config.getKey_usersInRoom(client.roomId), client.myUser.get('name'), function(err, data){
			// If data is EMPTY, then the user is still gone, so we can actually broadcast the message now.
			if(!data){
				// Broadcast the 'part' to all clients.
				broadcastToRoom(client, socket, {
					event: 'part',
					data: client.myUser.xport()
				});
			}
		});
	}, DELAY_MILLIS);
} // end broadcastDisconnectionInfo()


/** MESSAGE HANDLERS **/

/**
 * Processes a message sent by a client (and broadcasts it out to all users in the same room).
 */
function chatMessage(client, socket, msg){
	var chatEntry = new models.ChatEntry();
    chatEntry.mport(msg);
	storeAndBroadcastChatEntry(client, socket, chatEntry);
} // end chatMessage()

/**
 * Kicks and bans the specified user, then broadcasts the effects to other users.
 */
function kickBan(client, socket, msg){
	var kickBanCommand = new models.KickBanCommand();
    kickBanCommand.mport(msg);

	var userToBan = kickBanCommand.get('userToBan');

	// Find the hostname to make the request to.
	rc.hget(config.getKey_room(client.roomId), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error: getting wgServer for a room: ' + err);
		} else if (data) {
			var wikiHostname = data.replace(/^https?:\/\//i, "");

			// Ban the user via request to Wikia MediaWiki server ajax-endpoint.
		
			var requestHeaders = {
					'Host': wikiHostname
				};
			
			var requestUrl = config.KICKBAN_URL;
			requestUrl += "&userToBan=" + encodeURIComponent(userToBan);
			requestUrl +=  "&key=" + client.userKey ;
			requestUrl += "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching ajax requests (at least on dev boxes) when we don't want it to... so cachebust it.
			var httpClient = http.createClient(config.WIKIA_PROXY_PORT, config.WIKIA_PROXY_HOST);
			var httpRequest = httpClient.request("GET", requestUrl, requestHeaders);
			console.log("Trying to ban '" + userToBan + "' by hitting hostname " + wikiHostname + " with URL:\n" + requestUrl);
			httpRequest.addListener("response", function (response) {
				var responseBody = "";
				response.addListener("data", function(chunk) {
					responseBody += chunk;
				});
				response.addListener("end", function() {
					var data;
					try{
						data = JSON.parse(responseBody);
					} catch(e){
						data = {
							error: '',
							errorWfMsg: 'chat-err-communicating-with-mediawiki',
							errorMsgParams: []
						};
						console.log("Error: while parsing result of kickBan call to MediaWiki server. Error was: ");
						console.log(e);
						console.log("Response that didn't parse was:\n" + responseBody);
					}

					// Process response from MediaWiki server and then kick the user from all clients.
					if(data.error || data.errorWfMsg){
						sendInlineAlertToClient(client, data.error, data.errorWfMsg, data.errorMsgParams);
						
						if(data.doKickAnyway){
							kickedUser = new models.User({name: userToBan});
							kickUserFromRoom(client, socket, kickedUser, client.roomId);
						}
					} else {
		// TODO: ONCE WE HAVE A LIST OF CLIENTS, INSTEAD OF BUILDING A FAKE... LOOP THROUGH THE USERS IN THIS CHAT AND FIND THE REAL ONE. THAT'S FAR SAFER/BETTER.
		// TODO: The users are in a hash now... grab (or build) the user from that data or obj and use that instead of this fake user.
						// Build a user that looks like the one that got banned... then kick them!
						kickedUser = new models.User({name: userToBan});
						broadcastInlineAlert(client, socket, 'chat-user-was-kickbanned', [kickedUser.get('name')], function(){
							// The user has been banned and the ban has been broadcast, now physically remove them from the room.
							kickUserFromRoom(client, socket, kickedUser, client.roomId);
						});
					}
				});
			});
			httpRequest.end();
		}
	});
} // end kickBan()

/**
 * Add the chatmoderator group to the user whose username is specified in the command (if allowed).
 */
function giveChatMod(client, socket, msg){
	var giveChatModCommand = new models.GiveChatModCommand();
	giveChatModCommand.mport(msg);

	var userToPromote = giveChatModCommand.get('userToPromote');

	// Find the hostname to make the request to.
	rc.hget(config.getKey_room(client.roomId), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error: getting wgServer for a room: ' + err);
		} else if (data) {
			var wikiHostname = data.replace(/^https?:\/\//i, "");

			// Ban the user via request to Wikia MediaWiki server ajax-endpoint.
			var requestHeaders = {
				'Host': wikiHostname
			};
			var requestUrl = config.GIVECHATMOD_URL;
			requestUrl +=  "&key=" + client.userKey ;
			requestUrl += "&userToPromote=" + encodeURIComponent(userToPromote);
			requestUrl += "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching ajax requests (at least on dev boxes) when we don't want it to... so cachebust it.
			
			
			console.log('================giveChatMod===============');
			console.log(requestUrl);
			console.log('================/giveChatMod==============');
			
			var httpClient = http.createClient(config.WIKIA_PROXY_PORT, config.WIKIA_PROXY_HOST);
			var httpRequest = httpClient.request("GET", requestUrl, requestHeaders);
			httpRequest.addListener("response", function (response) {
				var responseBody = "";
				response.addListener("data", function(chunk) {
					responseBody += chunk;
				});
				response.addListener("end", function() {
					var data;
					try{
						data = JSON.parse(responseBody);
					} catch(e){
						data = {
							error: '',
							errorWfMsg: 'chat-err-communicating-with-mediawiki',
							errorMsgParams: []
						};
						console.log("Error: while parsing result of giveChatMod call to MediaWiki server. Error was: ");
						console.log(e);
						console.log("Response that didn't parse was:\n" + responseBody);
					}

					// Either send the error to the client who tried this action, or (if it was a success), send the updated User to all clients.
					if(data.error || data.errorWfMsg){
						sendInlineAlertToClient(client, data.error, data.errorWfMsg, data.errorMsgParams);
					} else {
		// TODO: ONCE WE HAVE A LIST OF CLIENTS, INSTEAD OF BUILDING A FAKE... LOOP THROUGH THE USERS IN THIS CHAT AND FIND THE REAL ONE. THAT'S FAR SAFER/BETTER.
		// TODO: The users are in a hash now... grab the user, then send them.
						// Build a user that looks like the one that got banned... then kick them!
						promotedUser = new models.User({name: userToPromote});

						// Broadcast inline-alert saying that A has made B a chatmoderator.
						broadcastInlineAlert(client, socket, 'chat-inlinealert-a-made-b-chatmod', [client.myUser.get('name'), promotedUser.get('name')], function(){
							// Force the user to reconnect so that their real state is fetched again and is broadcast to all users (whose models will be updated).
							var promotedClientId = sessionIdsByKey[config.getKey_userInRoom(promotedUser.get('name'), client.roomId)];
							if(typeof promotedClientId != 'undefined'){
								socket.socket(promotedClientId).json.send({
									event: 'forceReconnect'
								});
							}
						});
					}
				});
			});
			httpRequest.end();
		}
	});

} // end giveChatMod()

/**
 * Given a User model and a room id, disconnect the client if that username has a client connected. Also,
 * remove them from the room hash in redis.
 */
function kickUserFromRoom(client, socket, userToKick, roomId, callback){
	// Removing the user from the room.
	console.log("Kicking " + userToKick.get('name') + " from room " + roomId);
	var hashOfUsersKey = config.getKey_usersInRoom(roomId);
	rc.hdel(hashOfUsersKey, userToKick.get('name'), function(){
		kickUserFromServer(client, socket, userToKick, roomId);

		if(typeof callback == "function"){
			callback();
		}
	});
} // end kickUserFromRoom()

/**
 * Given a User model and a room id, disconnect the client if that username has a client connected.
 * This only closes their connection, but does not delete their entry from the room in redis. If you
 * want to remove the user from the room also, use kickUserFromRoom() instead.
 */
function kickUserFromServer(client, socket, userToKick, roomId){
	// Force-close the kicked user's connection so that they can't interact anymore.
	console.log("Force-closing connection for kicked user: " + userToKick.get('name'));
	var kickedClientId = sessionIdsByKey[config.getKey_userInRoom(userToKick.get('name'), roomId)];

	if(typeof kickedClientId != 'undefined'){
		// If we're kicking the user (for whatever reason) they shouldn't try to auto-reconnect.
		socket.socket(kickedClientId).json.send({
			event: 'disableReconnect'
		});

		// To prevent race-conditions, we don't have any users kicked by this function get removed from
		// redis. Setting this variable here lets clientDisconnect() know not to delete the user from the
		// room in redis.
		socket.socket(kickedClientId).doNotRemoveFromRedis = true;
		socket.socket(kickedClientId).disconnect();
		// This closes the connection (takes a few seconds) after calling the clientDisconnect() handler which will
		// broadcast the 'part' and delete the session id from the sessionIdsByKey hash.

		//clientDisconnect(socket.socket(kickedClientId), socket);
		// NOTE: This is the way fzysqr does it (as opposed to the ._onDisconnect() done above).  It might close the connection more quickly (the _onDisconnect() works and is tested but the client stays open for a few seconds).
		//socket.clients[kickedClientId].send({ event: 'disconnect' });
		//socket.clients[kickedClientId].connection.end();
	}
} // end kickUserFromServer()

/**
 * Sets the current user's status and broadcasts it out to the other users in the same room.
 */
function setStatus(client, socket, setStatusData){
	var setStatusCommand = new models.KickBanCommand();
    setStatusCommand.mport(setStatusData);

	var userName = client.myUser.get('name');
	var roomId = client.roomId;
	var userJson;
	rc.hget( config.getKey_usersInRoom( roomId ), userName, function(err, userData){
		if (err) {
			console.log('Error: while trying to load user data for "' + userName + '" in room: "' + roomId + '": ' + err);
		} else if(userData){
			// Modify the user's status and store them back in the hash
			userJson = JSON.parse( userData );
			userJson.statusState = setStatusCommand.get('statusState');
			userJson.statusMessage = setStatusCommand.get('statusMessage');
			rc.hset( config.getKey_usersInRoom( roomId ), userName, JSON.stringify(userJson), function(){
				// Broadcast the user as an update to everyone in the room
				var userToUpdate = new models.User( userJson );
				broadcastToRoom(client, socket, {
					event: 'updateUser',
					data: userToUpdate.xport()
				});
			});
		} else {
			console.log("Attempted to set status for user '" + userName + "', but that user was not found in room '" + roomId + "'");
		}
	});
} // end setStatus()



/** HELPER FUNCTIONS **/

/**
 * Sends some text to the client specified as an InlineAlert but does not store it
 * or persist it anywhere.
 *
 * Can use client-side i18n, so expects EITHER a 'text' string or a MediaWiki message name and parameters (pass in an
 * empty string for 'text' parameter if using client-side i18n).
 */
function sendInlineAlertToClient(client, text, wfMsg, msgParams, callback){
	var inlineAlert = new models.InlineAlert({
		text: text,
		wfMsg: wfMsg,
		msgParams: msgParams
	});
	client.json.send({
		event: 'chat:add',
		data: inlineAlert.xport()
	});
	if(typeof callback == "function"){
		callback();
	}
} // end sendInlineAlertToClient()

/**
 * Given some text, adds the InlineAlert to the model and broadcasts it out to the other clients in the room.
 *
 * NOTE: Not using this for join/part/kickbanned anymore because of https://wikia.fogbugz.com/default.asp?4766
 * Those messages are now transient/ephemeral and are just sent with broadcastInlineAlert
 */
function storeAndBroadcastInlineAlert(client, socket, text, callback){
	var inlineAlert = new models.InlineAlert({text: text});
	storeAndBroadcastChatEntry(client, socket, inlineAlert, callback);
} // end storeAndBroadcastInlineAlert()

/**
 * Given a ChatEntry (which might be of the InlineAlert subclass), store it to the model and
 * broadcast it to all of the clients in the room.
 */
function storeAndBroadcastChatEntry(client, socket, chatEntry, callback){
    rc.incr('next.chatentry.id', function(err, newId) {
		// Set the id from redis, and the name/avatar based on what we KNOW this client's credentials to be.
		// Originally, the client may spoof a name/avatar, but we will ignore what they gave us and override them here.
		var now = new Date();
		chatEntry.set({
			id: newId,
			name: client.myUser.get('name'),
			avatarSrc: client.myUser.get('avatarSrc'),
			text: processText(chatEntry.get('text'), client),
			timeStamp: now.getTime()
		});

        var expandedMsg = chatEntry.get('id') + ' ' + chatEntry.get('name') + ': ' + chatEntry.get('text');
        console.log('(' + client.sessionId + ':' + chatEntry.get('name') + ') ' + expandedMsg);

		var chatEntriesInRoomKey = config.getKey_chatEntriesInRoom(client.roomId);
        rc.rpush(chatEntriesInRoomKey, chatEntry.xport(), function(){
			// Keep the list to a defined max length.
			pruneExtraMessagesFromRoom( chatEntriesInRoomKey );
		
			// Send to everyone in the room.
			broadcastChatEntryToRoom(client, socket, chatEntry, callback);
		});
    });
} // end chatMessage()

/**
 * To prevent the messages backlog from expanding indefinitely, we call this (currently when a message is added) to make
 * sure we're not storing too many messages.
 */
function pruneExtraMessagesFromRoom(chatEntriesInRoomKey){
	rc.llen(chatEntriesInRoomKey, function(err, len){
		if(err){
			console.log("Error: while trying to get length of list of messages in '" + chatEntriesInRoomKey + "'. Error msg: " + err);
		} else if( len > config.MAX_MESSAGES_IN_BACKLOG + 1 ){
			console.log("Found a bunch of extra messages in '" + chatEntriesInRoomKey + "'.  Getting rid of the oldest " + (len - config.MAX_MESSAGES_IN_BACKLOG) + " of them.");
			rc.ltrim(chatEntriesInRoomKey, (-1 * config.MAX_MESSAGES_IN_BACKLOG), -1, redis.print);
		} else if( len == (config.MAX_MESSAGES_IN_BACKLOG + 1)){
			// This seems like it'd be faster than ltrim even though ltrim says it's O(N) where N is number to remove and this is O(1).
			console.log("Trimming extra entry from list of messages in '" + chatEntriesInRoomKey + "'");
			rc.lpop(chatEntriesInRoomKey, redis.print);
		}
	});
	console.log("Done pruning any old messages in room (if needed).");
} // end pruneExtraMessagesFromRoom()

/**
 * For broadcasting text (as an ephemeral - not persisted - InlineAlert) to all
 * members of the same room that client is in.
 *
 * @param wfMsg - the MediaWiki message name (will be translated client-side).
 * @param msgParams - an array containing the parameters (if any) to be passed in with the i18n message to $.msg().
 */
function broadcastInlineAlert(client, socket, wfMsg, msgParams, callback){
	var inlineAlert = new models.InlineAlert({
		text: '',
		wfMsg: wfMsg,
		msgParams: msgParams
	});
	broadcastChatEntryToRoom(client, socket, inlineAlert, callback);
} // end broadcastInlineAlert()

/**
 * Send the 'chat:add' update to all clients in the chat room.  This assumes that the caller
 * has already added the chatEntry to the model if it wants the chatEntry to be in the model.
 */
function broadcastChatEntryToRoom(client, socket, chatEntry, callback){
	broadcastToRoom(client, socket, {
		event: 'chat:add',
		data:chatEntry.xport()
	},[], callback);
} // end broadcastChatEntryToRoom()

/**
 * Broadcasts the 'data' to all of the clients who are in the room specified
 * by 'roomId'.
 *
 * 'callback' is optional, if defined it will be called after the broadcasting is complete.
 */

//TODO: use native join/emit from 0.7 sockets.io
function broadcastToRoom(client, socket, data, users, callback){
	var roomId = client.roomId;
	// Get the set of members from redis.
	console.log("Broadcasting to room " + roomId);
	rc.hgetall(config.getKey_usersInRoom( roomId ), function(err, usernameToData){
		if (err) {
			console.log('Error: while trying to find members of room "' + roomId + '": ' + err);
		} else {
			//console.log("Raw data from key " + config.getKey_usersInRoom( roomId ) + ": ");
			//console.log(usernameToData);
			//(input instanceof Array)
			console.log("usernameToData:");

			console.log(users);
			console.log(usernameToData);
			
			var usernameToDataFilterd = {};
			
			if((users instanceof Array) && users.length > 0) {
				for( var i in users ) {
					if(typeof(usernameToData[users[i]]) != 'undefined') {
						usernameToDataFilterd[users[i]] = usernameToData[users[i]];	
					}
				}
			} else {
				usernameToDataFilterd = usernameToData;
			}
			
			console.log(usernameToDataFilterd);
			
			_.each(usernameToDataFilterd, function(userData){
				var userModel = new models.User( JSON.parse(userData) );
				
				console.log("\tSENDING TO " + userModel.get('name'));
				var socketId = sessionIdsByKey[ config.getKey_userInRoom(userModel.get('name'), roomId) ];
				
				if(socketId){
					
					console.log("============ SOCKET "+socketId+" ==========================================");
					//console.log(socket.socket(socketId));
					console.log("============ /SOCKET "+socketId+" ==========================================");
					
					if( typeof socket.socket(socketId).sessionId  == "undefined"){
						// This happened once (and before this check was here, crashed the server).  Not sure if this is just a normal side-effect of the concurrency or is a legit
						// problem. This logging should help in debugging if this becomes an issue.
						console.log("WARNING: Somehow the client socket for " + userModel.get('name') + " is totally closed but their socketId is still in the hash. Potentially a race-condition?");
						delete sessionIdsByKey[ config.getKey_userInRoom(userModel.get('name'), roomId) ];
					} else {
						io.sockets.socket(socketId).json.send(data);
					}
				}
			});
			
			if(typeof callback == "function"){
				callback();
			}
		}
	});
} // end broadcastToRoom()

/**
 * Does pre-processing of text (currently used BEFORE storing it in redis).
 *
 * Some wg variables (stored in the client) are needed for link rewriting, etc. so
 * the second param should be the client of the user who sent the message.
 */
function processText(text, client) {
	// Prevent simple HTML/JS vulnerabilities (need to do this before other rewrites).
	text = text.replace(/</g, "&lt;");
	text = text.replace(/>/g, "&gt;");

	// TODO: Use the wgServer and wgArticlePath from the chat room. Maybe the room should be passed into this function? (it seems like it could be called a bunch of times in rapid succession).
	
	// Linkify local wiki links (eg: http://thiswiki.wikia.com/wiki/Page_Name ) as shortened links (like bracket links)
	var localWikiLinkReg = client.wgServer + client.wgArticlePath;
	localWikiLinkReg = localWikiLinkReg.replace(/\$1/, "([-A-Z0-9+&@#\/%?=~_|'!:,.;]*[-A-Z0-9+&@#\/%=~_|'])");
	text = text.replace(new RegExp(localWikiLinkReg, "i"), "[[$1]]"); // easy way... will re-write this to a shortened link later in the function.

	// Linkify http://links
	var exp = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|'!:,.;]*[-A-Z0-9+&@#\/%=~_|'])/ig;
	var pageLink = "";
	if(text.match(exp)){
		pageLink = unescape( exp.exec(text)[1] );
	}
	text = text.replace(exp, "<a href='$1'>" + pageLink + "</a>");

	// Linkify [[Pipes|Pipe-notation]] in bracketed links.
	var exp = /\[\[([ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+#]*)\|([^\]\|]*)\]\]/ig;
	text = text.replace(exp, function(wholeMatch, article, linkText) {
		article = article.replace(/ /g, "_");
		linkText = linkText.replace(/_/g, " ");
		linkText = unescape( linkText );

		var path = client.wgServer + client.wgArticlePath;
		article = escape( article );
		article = article.replace(/%3a/ig, ":"); // make colons more human-readable (they don't really need to be escaped)
		var url = path.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});

	// Linkify [[links]] - the allowed characters come from http://www.mediawiki.org/wiki/Manual:$wgLegalTitleChars
	var exp = /(\[\[[ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+#]*\]\])/ig;
	text = text.replace(exp, function(match) {
		var article = match.substr(2, match.length - 4);
		article = article.replace(/ /g, "_");
		var linkText = article.replace(/_/g, " ");
		linkText = unescape( linkText );
		
		var path = client.wgServer + client.wgArticlePath;
		article = escape( article );
		article = article.replace(/%3a/ig, ":"); // make colons more human-readable (they don't really need to be escaped)
		var url = path.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});


	// Process emoticons (should be done after the linking because the link code is searching for URLs and the emoticons contain URLs).

	// Load the emoticon mapping. Since the mapping is loaded async for the client, the wiki-specific settings may not
	// have arrived yet... in that case, falls back to the default for this message.
	var emoticonMapping;
	if(typeof client.emoticonMapping === 'undefined'){
		emoticonMapping = new EmoticonMapping();

		// Use the default global mapping from Messaging Wiki (was loaded on server startup).
		emoticonMapping._settings =  defaultEmoticonMapping._settings;
		emoticonMapping._regexes = {};
	} else {
		emoticonMapping = client.emoticonMapping;
	}

	// Replace appropriate shortcuts in the text with the emoticons.
	text = emoticons.doReplacements(text, emoticonMapping);

	// If the emoticon mapping is still undefined on the client (it might have been fixed asynchronously already) then store the defaults
	// for now so that we don't have to recreate the default object for this client on every processText() call.
	if(typeof client.emoticonMapping === 'undefined'){
		client.emoticonMapping = emoticonMapping;
	}

	return text;
} // end processText()

/**
 * Helper-function to log the details of a more complex object.
 */
function debugObject(obj, padding){
	if(!padding){padding = '';}

	if(typeof(obj) == 'object'){
		console.log(padding + "OBJECT: ");
		for(var index in obj){
			//if(obj.hasOwnProperty(index)){
				var item = obj[index];
				if(typeof(item) == 'object'){
					debugObject(item, "   "); // recursively show the sub-item (indented a bit)
				} else {
					console.log(padding + "   " + index + ": " + item);
				}
			//}
		}
	} else {
		console.log(padding + "Not an object: " + obj);
	}
}















/**
 * Given an already set-up httpClient, a wiki hostname, and the page-title of an article
 * on that hostname, fetches the wikitext via the MediaWiki API and passes the wikitext
 * to the callback.  If the call to the API doesn't work, the callback will not be called.
 */
function getWikiText(httpClient, wikiHostname, pageTitle, callback){
	// Trying to fetch the wikitext of the emoticon page.
	var requestHeaders = {
		'Host': wikiHostname
	};
	//http://lyrics.sean.wikia-dev.com/api.php?action=query&prop=revisions&titles=MediaWiki:Emoticons&rvprop=content&format=jsonfm <-- human-readable json
	var requestUrl = config.API_URL + "?action=query&prop=revisions&rvprop=content&format=json&titles=" + pageTitle ;
	var httpRequest = httpClient.request("GET", requestUrl, requestHeaders);
	httpRequest.addListener("response", function (response) {
		//debugObject(client.request.headers);
		var responseBody = "";
		//response.setBodyEncoding("utf8");
		response.addListener("data", function(chunk) {
			responseBody += chunk;
		});
		response.addListener("end", function() {
			try{
				data = JSON.parse(responseBody);
			} catch(e){
				console.log("Error: while parsing result of API call for wikitext. Error was: ");
				console.log(e);
				console.log("Response that didn't parse was:\n" + responseBody);
			}

			var wikiText = "";
			//console.log("=============API data================");
			//console.log(data);

			// Is there a less messy way to dig down to the value without all of these checks?
			if(data && data.query && data.query.pages){
				var pages = data.query.pages;
				if(pages){
					var pagesKeys = Object.keys(pages);
					if(pagesKeys[0] && pages[pagesKeys[0]] && pages[pagesKeys[0]].revisions){
						var revisions = pages[pagesKeys[0]].revisions;
						if(revisions && revisions[0]){
							var rev = revisions[0];
							if(rev && rev['*']){
								wikiText = rev['*'];
								console.log("Fetched wikitext: \n" + wikiText);
							}
						}
					}
				}
			}
			//console.log("=============/API data================");

			callback(wikiText);
		});
	});
	httpRequest.end();

} // end getWikiText()
