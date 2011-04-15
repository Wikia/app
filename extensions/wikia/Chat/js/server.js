
const NODE_EXIT_USAGE = 1;
var WIKIA_PROXY_HOST, WIKIA_PROXY_PORT;
const MAX_MESSAGES_IN_BACKLOG = 50; // how many messages each room will store for now. only longer than NUM_MESSAGES_TO_SHOW_ON_CONNECT for potential debugging.
const NUM_MESSAGES_TO_SHOW_ON_CONNECT = 10;

// Choose proxy settings based on whether this is development or production.
if(process.argv.length < 3){
	console.log("ERROR: You must specify a parameter of which server to run as. Either 'dev' (for development) or 'prod' (for production).");
	process.exit(NODE_EXIT_USAGE);
} else {
	var whichServer = process.argv[2].toLowerCase();
	switch(whichServer){
		case "dev":
		case "development":
			WIKIA_PROXY_HOST = "dev-sean";
			WIKIA_PROXY_PORT = 80;
			console.log("Running as DEVELOPMENT server.");
			break;

		case "prod":
		case "production":
			WIKIA_PROXY_HOST = "127.0.0.1";
			WIKIA_PROXY_PORT = 6081;
			console.log("Running as PRODUCTION server.");
			break;

		default:
			console.log("ERROR: Environment not recognized: '" + whichServer + "'. Please choose either 'dev' (for development) or 'prod' (for production).");
			process.exit(NODE_EXIT_USAGE);
			break;
	}
}

// NOTE: WE COULD REPLACE activeClients BY JUST USING rc.scard(getKey_usersInRoom(client.roomId)); ... IT'S O(1) .. alternately, we could keep both as a way to doublecheck.
// NOTE: WE COULD REPLACE activeClients BY JUST USING rc.scard(getKey_usersInRoom(client.roomId)); ... IT'S O(1) .. alternately, we could keep both as a way to doublecheck.

// TODO: Consider using this to catch uncaught exceptions (and then exit anyway):
//process.on('uncaughtException', function (err) {
//  console.log('Caught exception: ' + err);
//  console.log('Stacktrace: ');
//	console.log(err.stack);
//	console.log('Full, raw error: ');
//	console.log(err);
//	process.exit(1);
//	// TODO: is there some way to email us here (if on production) so that we know the server crashed?
//});

var CHAT_SERVER_PORT = 8000;
var API_SERVER_PORT = 8001;

var AUTH_URL = "/?action=ajax&rs=ChatAjax&method=getUserInfo"; // do NOT add hostname into this URL.
var KICKBAN_URL = "/?action=ajax&rs=ChatAjax&method=kickBan";

var app = require('express').createServer()
    , jade = require('jade')
    , socket = require('socket.io').listen(app)
    , _ = require('underscore')._
    , Backbone = require('backbone')
    , redis = require('redis')
    , rc = redis.createClient()
    , models = require('./models/models')
	, urlUtil = require('url');

var http = require("http");

console.log("== Starting Node Chat Server ==");

rc.on('error', function(err) {
    console.log('Error ' + err);
});


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
rc.keys( getPrefix_usersInRoom()+":*", function(err, data){
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

//create local state
var sessionIdsByKey = {}; // for each room/username combo, store the sessionId so that we can send targeted messages.
socket.on('connection', function(client){
	client.isAuthenticated = false;

	// On initial connection, just wait around for the client to send it's authentication info.
    client.on('message', function(msg){messageDispatcher(client, socket, msg)});
	
	// Send a message to the client to cause it to send it's authentication info back to the server.
	client.send({
		event: 'auth',
    });

	console.log("Raw connection recieved. Waiting for authentication info from client.");
});

/**
 * Bound to the 'message' event, gets any message from the client. If the user
 * is not authenticated, this won't listen to anything other than authentications.
 */
function messageDispatcher(client, socket, data){
	if( ! client.isAuthenticated ){
		console.log("Dispatching to authConnection.");
		authConnection(client, socket, data)
	} else {
		// The user is authed. Check to make sure their client sessionId still exists. If it doesn't, we probably banned them.
		console.log("Checking to make sure user isn't banned.");
		var sessionId = sessionIdsByKey[getKey_userInRoom(client.myUser.get('name'), client.roomId)];
		if((typeof sessionId == "undefined") || (sessionId != client.sessionId)){
			// Message ignored. Log the reason.
			if(typeof sessionId == "undefined"){
				console.log("GOT A MESSAGE FROM \""+ client.myUser.get('name') +" WITH NO socket.io sessionId. ASSUMING THEY ARE BANNED AND SKIPPING.");
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
					console.log("Could not find recognized msgType to handle data: ");
					console.log(data);
					break;
			}
		}
	}
} // end messageDispatcher()

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
	var auth = new models.AuthInfo();
	auth.mport(authData);

	console.log("Authentication info recieved from client. Verifying with Wikia MediaWiki app server...");

	// Need to auth with the correct wiki. Lookup the hostname for the chat in redis.
	console.log("Trying to find the wgServer for the room key: " + getKey_room( auth.get('roomId') ));
	rc.hget(getKey_room( auth.get('roomId') ), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error getting wgServer for a room: ' + err);
		} else if (data) {
			console.log("Got wgServer in data: " + data);
			var wikiHostname = data.replace(/^https?:\/\//i, "");
			console.log("Making getUserInfo request to host: " + wikiHostname);

			// Format the cookie-data into the correct string for sending the data as a header.
			var roomId = auth.get('roomId');
			var cookieData = auth.get('cookie');
			var cookieStr = "";
			for(var index in cookieData){
				cookieStr += (cookieStr === "" ? "" : " ");
				cookieStr += index + "=" + cookieData[index] + ";"
			}
			client.cookieStr = cookieStr;
			console.log("Auth data: " + client.cookieStr);
			// Send auth cookies to apache to make sure this user is authorized & get the user information.
			var requestHeaders = {
				'Cookie': client.cookieStr,
				'Host': wikiHostname
			};
			var requestUrl = AUTH_URL + "&roomId=" + roomId;
			requestUrl += "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching this (at least on dev boxes) when we don't want it to... so cachebust it.

			console.log("Requesting user info from: " + requestUrl);

			var httpClient = http.createClient(WIKIA_PROXY_PORT, WIKIA_PROXY_HOST);
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
					}
					if( (data.canChat) && (data.isLoggedIn) ){
						client.isAuthenticated = true;
						client.isChatMod = data.isChatMod;
						client.roomId = roomId;
						// TODO: REFACTOR THIS TO TAKE ANY FIELDS THAT data GIVES IT.
						var name = data.username;
						var avatarSrc = data.avatarSrc;
						var editCount = data.editCount;
						var since = data.since;
						
						// User has been approved & their data has been set on the client. Put them into the chat.

						// TODO: REFACTOR THESE TO USE THE VALUE STORED IN THE 'chat' OBJ IN REDIS (remove the setting of these client vars from the ajax request also).
						// Extra wg variables that we'll need.
						client.wgServer = data.wgServer;
						client.wgArticlePath = data.wgArticlePath;
						// TODO: REFACTOR THESE TO USE THE VALUE STORED IN THE 'chat' OBJ IN REDIS (remove the setting of these client vars from the ajax request also).

 						rc.hincrby(getKey_room(client.roomId), 'activeClients', 1);

						client.on('disconnect', function(){clientDisconnect(client)});

						var nodeChatModel = new models.NodeChatModel();
						rc.lrange(getKey_chatEntriesInRoom(client.roomId), (-1 * NUM_MESSAGES_TO_SHOW_ON_CONNECT), -1, function(err, data) {
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
							console.log("Finding members of " + roomId);

							rc.hgetall(getKey_usersInRoom( roomId ), function(err, usernameToData){
								if (err) {
									console.log('Error: while trying to find members of room "' + roomId + '": ' + err);
								} else if(usernameToData){
									_.each(usernameToData, function(userData){
										var userModel = new models.User( JSON.parse(userData) );
										console.log("Room member of " + roomId + ": ");
										console.log(userModel);
										nodeChatModel.users.add(userModel);
									});
								}

								// Send this whole model to the newly-connected user.
								//console.log("SENDING INITIAL STATE...");
								//console.log(nodeChatModel.xport());
								client.send({
									event: 'initial',
									data: nodeChatModel.xport()
								});
								
								// Initial connection of the user (unless they're already connected).
								var connectedUser = nodeChatModel.users.find(function(user){return user.get('name') == name;});
								if(!connectedUser) {
									connectedUser = new models.User({
										name: name,
										avatarSrc: avatarSrc,
										isModerator: client.isChatMod, 
										editCount: editCount,
										since: since
									});
									nodeChatModel.users.add(connectedUser);
									console.log('[getConnectedUser] new user: ' + connectedUser.get('name') + ' on client: ' + client.sessionId);
								}
								client.myUser = connectedUser;
								
								// If this same user is already in the sessionIdsByKey hash, then they must be connected in
								// another browser. Kick that other instance before continuing (multiple instances cause all kinds of weirdness.
								var existingId = sessionIdsByKey[getKey_userInRoom(client.myUser.get('name'), client.roomId)];
								if(typeof existingId != "undefined"){
									// Send the old client a notice that they're about to be disconnected and why.
									var oldClient = socket.clients[existingId];
									if(typeof oldClient != "undefined"){
										// TODO: i18n: how?
										sendInlineAlertToClient(oldClient, "You have connected from another browser. This connection will be closed.", function(){
											// Looks like we're kicking ourself, but since we're not in the sessionIdsByKey map yet,
											// this will only kick the other instance of this same user connected to the room.
											kickUserFromRoom(oldClient, socket, client.myUser, client.roomId, function(){
												// This needs to be done after the user is removed from the room.  Since clientDisconnect() is called asynchronously,
												// the user is explicitly removed from the room first, then clientDisconnect() is prevented from attempting to remove
												// the user (since that may get called at some point after formallyAddClient() adds the user intentionally).
												formallyAddClient(client, socket, connectedUser);
											});
										});
									}
								} else {
									// Put the user info into the room hash in redis, and add the client to the in-memory (not redis) hash of connected sockets.
									formallyAddClient(client, socket, connectedUser);
								}
							});
						});

					} else {
						console.log("User failed authentication. Error from server was: " + data.errorMsg);
						sendInlineAlertToClient(client, data.errorMsg);
					}
				});
			});
			httpRequest.end();
		} else {
			console.log("Didn't get data, but returned");
		}
	}); // end of block for getting wgServer from the room's hash in redis.
	console.log("Started request to get wgServer from redis");
} // end of socket connection code

/**
 * Adds the client to their room in redis and adds their sessionId to the hash of sessionIdsByKey.
 *
 * This should only be done after any duplicates of this user have been ejected from the room already (in the case
 * of the same user connecting from multiple browsers).
 */
function formallyAddClient(client, socket, connectedUser){
	// Add the user to the set of users in the room in redis.
	var hashOfUsersKey = getKey_usersInRoom(client.roomId);
	var userData = client.myUser.attributes;
	delete userData.id;

	sessionIdsByKey[getKey_userInRoom(client.myUser.get('name'), client.roomId)] = client.sessionId;
	rc.hset(hashOfUsersKey, client.myUser.get('name'), JSON.stringify(userData), function(err, data){
		// Broadcast the join to all clients.
		broadcastToRoom(client, socket, {
			event: 'join',
			joinData: connectedUser.xport()
		});

		// TODO: FIGURE OUT A GOOD WAY TO GET THIS MESSAGE i18n'ed.
		storeAndBroadcastInlineAlert(client, socket, connectedUser.get('name') + " has joined the chat.");
	});
} // end formallyAddClient()

/**
 * Called when a client disconnects from the server.
 *
 * If client has property 'doNotRemoveFromRedis' set to true, then the user will be removed from the room hash in redis (this is used
 * sometimes to prevent race conditions).
 */
function clientDisconnect(client) {
	// Remove the in-memory mapping of this user in this room to their sessionId
	delete sessionIdsByKey[getKey_userInRoom(client.myUser.get('name'), client.roomId)];

	// Remove the user from the set of usernames in the current room (in redis).
	if(client.doNotRemoveFromRedis){
		console.log("Not removing user from room, just broadcasting their part & the associated inline alert for " + client.myUser.get('name'));
		broadcastDisconnectionInfo(client, socket);
	} else {
		console.log("Disconnected: " + client.myUser.get('name') + " and about to remove them from the room in redis & broadcast the part and InlineAlert...");
		var hashOfUsersKey = getKey_usersInRoom(client.roomId);
		rc.hdel(hashOfUsersKey, client.myUser.get('name'), function(err, data){
			if (err) {
				console.log('Error: while trying to remove user "' + client.myUser.get('name') + '" from room "' + client.roomId + '": ' + err);
			} else {
				// Decrement the number of active clients in the room.
				rc.hincrby(getKey_room(client.roomId), 'activeClients', -1);

				broadcastDisconnectionInfo(client, socket);
			}
		});
	}
} // end clientDisconnect()

/**
 * After a client has been disconnected, broadcast the part and the associated inline-alert to all remaining members of the room.
 */
function broadcastDisconnectionInfo(client, socket){
	// Broadcast the 'part' to all clients.
	broadcastToRoom(client, socket, {
		event: 'part',
		data: client.myUser.xport()
	});

	// TODO: FIGURE OUT A GOOD WAY TO GET THIS MESSAGE i18n'ed.
	storeAndBroadcastInlineAlert(client, socket, client.myUser.get('name') + " has left the chat.");
} // end broadcastDisconnectionInfo()

// Start the main chat server listening.
app.listen(CHAT_SERVER_PORT);
console.log("Chat server running on port " + CHAT_SERVER_PORT);

// Create the API server (which fills requests from the MediaWiki server).
// TODO: IS THERE A CLEAN WAY TO EXTRACT THIS TO ANOTHER FILE?
http.createServer(function (req, res) {
	apiDispatcher(req, res, function(result){
		// SUCCESS CALLBACK
		res.writeHead(200, {'Content-Type': 'application/json'});
		res.write( JSON.stringify(result) );
		res.end();
	}, function(errMsg){
		// ERROR CALLBACK
		res.writeHead(400, {'Content-Type': 'text/plain'});
		var errorData = {
			'errorMsg': errMsg
		}
		res.write( JSON.stringify(errorData) );
		res.end();
	});

}).listen(API_SERVER_PORT);
console.log("API server running on port " + API_SERVER_PORT);

/**
 * Dispatch the request to the correct destination and instruct them to end up in the
 * resulting callbacks.
 */
function apiDispatcher(req, res, successCallback, errorCallback){
	var reqData = urlUtil.parse(req.url, true);
	if(reqData.query.func){
		var func = reqData.query.func.toLowerCase();
		
		if(func == "getdefaultroomid"){
			// TODO: FIXME: ADD SOME TOKEN-VERIFICATION. This would make sure that only the MediaWiki app is creating rooms (it can check permissions, make sure the extraDataString is good, etc.).
			// TODO: FIXME: ADD SOME TOKEN-VERIFICATION. This would make sure that only the MediaWiki app is creating rooms (it can check permissions, make sure the extraDataString is good, etc.).

			api_getDefaultRoomId(reqData.query.wgCityId, reqData.query.defaultRoomName,
								 reqData.query.defaultRoomTopic, reqData.query.extraDataString,
								 successCallback, errorCallback);

		} else if(func == "getcityidforroom"){
			api_getCityIdForRoom(reqData.query.roomId, successCallback, errorCallback);
		} else if(func == "getusersinroom"){
			api_getUsersInRoom(reqData.query.roomId, successCallback, errorCallback);
		}
	} else {
		errorCallback("Must provide a 'func' to execute.");
	}
}




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
	rc.hget(getKey_room(client.roomId), 'wgServer', function(err, data) {
		if (err) {
			console.log('Error: getting wgServer for a room: ' + err);
		} else if (data) {
			var wikiHostname = data.replace(/^https?:\/\//i, "");

			// Ban the user via request to Wikia MediaWiki server ajax-endpoint.
			var requestHeaders = {
				'Cookie': client.cookieStr,
				'Host': wikiHostname
			};
			var requestUrl = KICKBAN_URL;
			requestUrl += "&userToBan=" + encodeURIComponent(userToBan);
			requestUrl += "&cb=" + Math.floor(Math.random()*99999); // varnish appears to be caching ajax requests (at least on dev boxes) when we don't want it to... so cachebust it.
			var httpClient = http.createClient(WIKIA_PROXY_PORT, WIKIA_PROXY_HOST);
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
						data = {'error': "Error communicating w/MediaWiki server."}; // probably can't i18n this msg since this only happens when we CAN'T get a result anyway.
						console.log("Error: while parsing result of kickBan call to MediaWiki server. Error was: ");
						console.log(e);
						console.log("Response that didn't parse was:\n" + responseBody);
					}

					// Process response from MediaWiki server and then kick the user from all clients.
					if(data.error){
						sendInlineAlertToClient(client, data.error);
					} else {
		// TODO: ONCE WE HAVE A LIST OF CLIENTS, INSTEAD OF BUILDING A FAKE... LOOP THROUGH THE USERS IN THIS CHAT AND FIND THE REAL ONE. THAT'S FAR SAFER/BETTER.
		// TODO: The users in the room will soon be a hash.  Build the user from the hash and use that.
						// Build a user that looks like the one that got banned... then kick them!
						kickedUser = new models.User({name: userToBan});
						// TODO: FIGURE OUT A GOOD WAY TO GET THIS MESSAGE i18n'ed.
						storeAndBroadcastInlineAlert(client, socket, kickedUser.get('name') + " was kickbanned.", function(){
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
 * Given a User model and a room id, disconnect the client if that username has a client connected. Also,
 * remove them from the room hash in redis.
 */
function kickUserFromRoom(client, socket, userToKick, roomId, callback){
	// Removing the user from the room.
	var hashOfUsersKey = getKey_usersInRoom(roomId);
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
	var kickedClientId = sessionIdsByKey[getKey_userInRoom(userToKick.get('name'), roomId)];

	if(typeof kickedClientId != 'undefined'){
		// If we're kicking the user (for whatever reason) they shouldn't try to auto-reconnect.
		socket.clients[kickedClientId].send({
			event: 'disableReconnect',
		});

		// To prevent race-conditions, we don't have any users kicked by this function get removed from
		// redis. Setting this variable here lets clientDisconnect() know not to delete the user from the
		// room in redis.
		socket.clients[kickedClientId].doNotRemoveFromRedis = true;
		
		// This closes the connection (takes a few seconds) after calling the clientDisconnect() handler which will
		// broadcast the 'part' and delete the session id from the sessionIdsByKey hash.
// TODO: SWITCH THESE METHODS AND TEST KICKBANS AGAIN.
		socket.clients[kickedClientId]._onDisconnect();

		// This is the way fzysqr does it.  It might close the connection more quickly (the _onDisconnect() works and is tested but the client stays open for a few seconds).
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
	rc.hget( getKey_usersInRoom( roomId ), userName, function(err, userData){
		if (err) {
			console.log('Error: while trying to load user data for "' + userName + '" in room: "' + roomId + '": ' + err);
		} else if(userData){
			// Modify the user's status and store them back in the hash
			userJson = JSON.parse( userData );
			userJson.statusState = setStatusCommand.get('statusState');
			userJson.statusMessage = setStatusCommand.get('statusMessage');
			rc.hset( getKey_usersInRoom( roomId ), userName, JSON.stringify(userJson), function(){
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

function getKey_listOfRooms(cityId){ return "rooms_on_wiki:" + cityId; }
function getKey_nextRoomId(){ return "next.room.id"; }
function getKey_room(roomId){ return "room:" + roomId; }
function getKey_userInRoom(userName, roomId){
	// Key representing the presence of a single user in a specific room (that user may be in multiple rooms).
	// used by the in-memory sessionIdByKey hash, not by redis.. so not prefixed.
	return roomId + ":" + userName;
}
function getPrefix_usersInRoom(){ return "users_in_room"; }
function getKey_usersInRoom(roomId){ return getPrefix_usersInRoom() +":" + roomId; } // key for set of all usernames in the given room
function getKey_chatEntriesInRoom(roomId){ return "chatentries:" + roomId; }

/**
 * Sends some text to the client specified as an InlineAlert but does not store it
 * or persist it anywhere.
 */
function sendInlineAlertToClient(client, msgText, callback){
	var inlineAlert = new models.InlineAlert({text: msgText});
	client.send({
		event: 'chat:add',
		data: inlineAlert.xport()
	});
	if(typeof callback == "function"){
		callback();
	}
} // end broadcastInlineAlert

/**
 * Given some text, adds the InlineAlert to the model and broadcasts it out to the other clients in the room.
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
		chatEntry.set({
			id: newId,
			name: client.myUser.get('name'),
			avatarSrc: client.myUser.get('avatarSrc'),
			text: processText(chatEntry.get('text'), client)
		});

        var expandedMsg = chatEntry.get('id') + ' ' + chatEntry.get('name') + ': ' + chatEntry.get('text');
        console.log('(' + client.sessionId + ':' + chatEntry.get('name') + ') ' + expandedMsg);

		var chatEntriesInRoomKey = getKey_chatEntriesInRoom(client.roomId);
        rc.rpush(chatEntriesInRoomKey, chatEntry.xport(), function(){
			// Keep the list to a defined max length.
			pruneExtraMessagesFromRoom( chatEntriesInRoomKey );
		
			// Send to everyone in the room.
			broadcastChatEntry(client, socket, chatEntry, callback);
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
		} else if( len > MAX_MESSAGES_IN_BACKLOG + 1 ){
			console.log("Found a bunch of extra messages in '" + chatEntriesInRoomKey + "'.  Getting rid of the oldest " + (len - MAX_MESSAGES_IN_BACKLOG) + " of them.");
			rc.ltrim(chatEntriesInRoomKey, (-1 * MAX_MESSAGES_IN_BACKLOG), -1, redis.print);
		} else if( len == (MAX_MESSAGES_IN_BACKLOG + 1)){
			// This seems like it'd be faster than ltrim even though ltrim says it's O(N) where N is number to remove and this is O(1).
			console.log("Trimming extra entry from list of messages in '" + chatEntriesInRoomKey + "'");
			rc.lpop(chatEntriesInRoomKey, redis.print);
		}
	});
	console.log("Done pruning any old messages in room (if needed).");
} // end pruneExtraMessagesFromRoom()

/**
 * Send the 'chat:add' update to all clients in the chat room.  This assumes that the caller
 * has already added the chatEntry to the model if it wants the chatEntry to be in the model.
 *
 * TODO: RENAME TO broadcastChatEntryToRoom?
 */
function broadcastChatEntry(client, socket, chatEntry, callback){
	broadcastToRoom(client, socket, {
		event: 'chat:add',
		data:chatEntry.xport()
	}, callback);
} // end broadcastChatEntry()

/**
 * Broadcasts the 'data' to all of the clients who are in the room specified
 * by 'roomId'.
 *
 * 'callback' is optional, if defined it will be called after the broadcasting is complete.
 */
function broadcastToRoom(client, socket, data, callback){
	var roomId = client.roomId;

	// Get the set of members from redis.
	rc.hgetall(getKey_usersInRoom( roomId ), function(err, usernameToData){
		if (err) {
			console.log('Error: while trying to find members of room "' + roomId + '": ' + err);
		} else {
			console.log("Raw data from key " + getKey_usersInRoom( roomId ) + ": ");
			console.log(usernameToData);
			_.each(usernameToData, function(userData){
				var userModel = new models.User( JSON.parse(userData) );
				
				console.log("SENDING TO " + userModel.get('name'));
				var socketId = sessionIdsByKey[ getKey_userInRoom(userModel.get('name'), roomId) ];
				if(socketId){
					console.log("SOCKETID: " + socketId);
					socket.clients[socketId].send(data);
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
	text = text.replace(exp, "<a href='$1'>$1</a>");

	// Linkify [[Pipes|Pipe-notation]] in bracketed links.
	var exp = /\[\[([ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+]*)\|([^\]\|]*)\]\]/ig;
	text = text.replace(exp, function(wholeMatch, article, linkText) {
		article = article.replace(/ /g, "_");
		linkText = linkText.replace(/_/g, " ");

		var path = client.wgServer + client.wgArticlePath;
		var url = path.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});

	// Linkify [[links]] - the allowed characters come from http://www.mediawiki.org/wiki/Manual:$wgLegalTitleChars
	var exp = /(\[\[[ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+]*\]\])/ig;
	text = text.replace(exp, function(match) {
		var article = match.substr(2, match.length - 4);
		article = article.replace(/ /g, "_");
		var linkText = article.replace(/_/g, " ");
		var path = client.wgServer + client.wgArticlePath;

		var url = path.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});

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

/** API FUNCTIONS (for use by the MediaWiki server) **/

/**
 * Returns the id of the default chat for the given wiki.
 *
 * Expects the deafult room name and default topic name because those require MediaWiki-side i18n.
 *
 * If the chat doesn't exist, creates it.
 *
 * As per the API convention, passes json on success to the successCallback or an error message (a string) to
 * the errorCallback on error.
 */
function api_getDefaultRoomId(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback){
	// See if there are any rooms for this wiki and if there are, get the first one.
	var roomId = "";
	var roomName = "";
	var roomTopic = "";

	var keyForListOfRooms = getKey_listOfRooms(cityId);
	//console.log("About to get rooms using key: " + keyForListOfRooms);
	rc.llen(keyForListOfRooms, function(err, numRooms){
		if (err) {
			console.log('Warning: while getting length of list of rooms for wiki with cityId "'+ cityId + '": ' + err);

			// No luck loading the room... create it.
			api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback);
		} else if (numRooms && (numRooms != 0)) {
			//console.log("Found " + numRooms + " rooms on wiki with city '" + cityId + "'...");
			var roomIds = rc.lrange(keyForListOfRooms, 0, 1, function(err, roomIds){
				if (err) {
					console.log('Warning: while getting first room for cityId "'+ cityId + '": ' + err);

					// No luck loading the room... create it.
					api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback);
				} else if(roomIds){
					// For now, if there is more than one wiki in the room, we just grab the first as the default room.
					roomId = roomIds[0];
					var roomKey = getKey_room(roomId);
					rc.hgetall(roomKey, function(err, roomData){
						if(err){
							console.log("Warning: couldn't get hash data for room w/key '"+ roomKey + "': " + err);

							// No luck loading the room... create it.
							api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback);
						} else {
						
							console.log("Room data loaded: ");
							console.log(roomData);
						
							var result = {
								'roomId': roomId,
								'roomName': roomData.room_name,
								'roomTopic': roomData.room_topic
							};
							successCallback(result);
						}
					});
				} else {
					console.log("Warning: First room not found even though there were rooms a moment ago for cityId: " + cityId);

					// No luck loading the room... create it.
					api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback);
				}
			});
		} else {
			// No luck loading the room... create it.
			api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, successCallback, errorCallback);
		}
	});
} // end api_getDefaultRoomId()

/**
 * Create a chat room on the given wiki with the given name and topic, and return its roomId.
 *
 * The 'extraDataString' is a json string of a hash of data which should be stored in the 'room'
 * object for use in the chat server later.
 */
function api_createChatRoom(cityId, roomName, roomTopic, extraDataString, successCallback, errorCallback){
	var roomId = "";

	// Get the next id that a new room should have.
	rc.incr(getKey_nextRoomId(), function(err, roomId){
		if (err) {
			var errorMsg = 'Error: while getting length of list of rooms for wiki with cityId "'+ cityId + '": ' + err;
			console.log(errorMsg);
			errorCallback(errorMsg);
		} else {
			// Create the room.
			var roomKey = getKey_room( roomId );
			var extraData = {};
			if(extraDataString){
				try{
					extraData = JSON.parse( extraDataString );
				} catch(e){
					console.log("Error: while parsing extraDataString. Error is: ");
					console.log(e);
					extraData = {};
				}
			}

			// Store the room in redis.
			rc.hmset(roomKey, {
				'room_id': roomId,
				'room_name': roomName,
				'room_topic': roomTopic,
				'activeClients': 0,
				'wgCityId': cityId,
				'wgServer': extraData.wgServer,
				'wgArticlePath': extraData.wgArticlePath
			});

			// Add the room to the list of rooms on this wiki.
			rc.rpush(getKey_listOfRooms(cityId), roomId);

			var result = {
				'roomId': roomId,
				'roomName': roomName,
				'roomTopic': roomTopic
			};
			successCallback(result);
		}
	});
} // end api_createChatRoom()

/**
 * Given a roomId, returns the cityId which it has in redis (as JSON).
 */
function api_getCityIdForRoom(roomId, successCallback, errorCallback){
	rc.hget(getKey_room(roomId), 'wgCityId', function(err, cityId){
		if (err) {
			var errorMsg = 'Error: while getting wgCityId of room: "'+ roomId + '": ' + err;
			console.log(errorMsg);
			errorCallback(errorMsg);
		} else {
			var result = {
				'cityId': cityId
			};
			successCallback(result);
		}
	});
} // end api_getCityIdForRoom()

/**
 * Given a roomId, returns a list of the usernames of all users in the room (as JSON).
 */
function api_getUsersInRoom(roomId, successCallback, errorCallback){
	rc.hkeys(getKey_usersInRoom(roomId), function(err, users){
		if (err) {
			var errorMsg = 'Error: while getting wgCityId of room: "'+ roomId + '": ' + err;
			console.log(errorMsg);
			errorCallback(errorMsg);
		} else {
			if(!users){users = {};} // if the key doesn't exist, return an empty userlist
			successCallback(users);
		}
	});
} // end api_getUsersInRoom()
