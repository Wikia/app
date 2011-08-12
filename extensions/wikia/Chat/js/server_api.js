/**
 * @author Sean Colombo
 * @date 20110526
 *
 * NOTE: DO NOT START THIS SCRIPT DIRECTLY.  The API is controlled by
 * the same server.js file and its functions are just included from in there.
 */

var config = require("./server_config.js"); // our node-chat config
var http = require("http");
var urlUtil = require('url');
var redis = require('redis')
var rc = redis.createClient();
rc.on('error', function(err) {
    console.log('Error ' + err);
});

// Create the API server (which fills requests from the MediaWiki server).
http.createServer(function (req, res) {
	var reqData = urlUtil.parse(req.url, true);
	apiDispatcher(req, res, reqData, function(result){
		resg = res;
		// SUCCESS CALLBACK
		res.writeHead(200, {'Content-Type': 'application/json'});
		res.write( JSON.stringify( result ) );
		res.end();
	}, function(errMsg){
		// ERROR CALLBACK
		res.writeHead(400, {'Content-Type': 'text/plain'});
		var errorData = {
			'errorMsg': errMsg
		}
		res.write( JSON.stringify(errorData ) );
		res.end();
	});

}).listen(config.API_SERVER_PORT);
console.log("API server running on port " + config.API_SERVER_PORT);

/**
 * Dispatch the request to the correct destination and instruct them to end up in the
 * resulting callbacks.
 */
function apiDispatcher(req, res, reqData, successCallback, errorCallback){
	if(reqData.query.func){
		var func = reqData.query.func.toLowerCase();
		
		if(func == "getdefaultroomid"){
			// TODO: FIXME: ADD SOME TOKEN-VERIFICATION. This would make sure that only the MediaWiki app is creating rooms (it can check permissions, make sure the extraDataString is good, etc.).
			// TODO: FIXME: ADD SOME TOKEN-VERIFICATION. This would make sure that only the MediaWiki app is creating rooms (it can check permissions, make sure the extraDataString is good, etc.).
			
			api_getDefaultRoomId(reqData.query.wgCityId, reqData.query.defaultRoomName,
								 reqData.query.defaultRoomTopic, reqData.query.extraDataString, reqData.query.roomType, reqData.query.roomUsers, 
								 successCallback, errorCallback);

		} else if(func == "getcityidforroom"){
			api_getCityIdForRoom(reqData.query.roomId, successCallback, errorCallback);
		} else if(func == "getusersinroom"){
			api_getUsersInRoom(reqData.query.roomId, successCallback, errorCallback);
		} else if(func == "getroomslist"){
			api_getRoomsList(successCallback, errorCallback);
		} else if(func == "getstats"){
			api_getStats(successCallback, errorCallback);
		} else {
			errorCallback("Function not recognized: " + func);
		}
	} else {
		errorCallback("Must provide a 'func' to execute.");
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
function api_getDefaultRoomId(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users, successCallback, errorCallback){
	// See if there are any rooms for this wiki and if there are, get the first one.
	var roomId = "";
	var roomName = "";
	var roomTopic = "";
	
	users = typeof(users) == 'undefined' ? []:users.split(',');
	
	var keyForListOfRooms = config.getKey_listOfRooms(cityId, type, users);
	
	//console.log("About to get rooms using key: " + keyForListOfRooms);
	rc.llen(keyForListOfRooms, function(err, numRooms){
		if (err) {
			console.log('Warning: while getting length of list of rooms for wiki with cityId "'+ cityId + '": ' + err);

			// No luck loading the room... create it.
			api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users, successCallback, errorCallback);
		} else if (numRooms && (numRooms != 0)) {
			//console.log("Found " + numRooms + " rooms on wiki with city '" + cityId + "'...");
			var roomIds = rc.lrange(keyForListOfRooms, 0, 1, function(err, roomIds){
				if (err) {
					console.log('Warning: while getting first room for cityId "'+ cityId + '": ' + err);

					// No luck loading the room... create it.
					api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users,  successCallback, errorCallback);
				} else if(roomIds){
					// For now, if there is more than one wiki in the room, we just grab the first as the default room.
					roomId = roomIds[0];
					var roomKey = config.getKey_room(roomId);
					rc.hgetall(roomKey, function(err, roomData){
						if(err){
							console.log("Warning: couldn't get hash data for room w/key '"+ roomKey + "': " + err);

							// No luck loading the room... create it.
							api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users, successCallback, errorCallback);
						} else {
						
							console.log("Room data loaded for " + roomData.room_name);
							//console.log(roomData);
						
							var result = {
								'type' : users,
								'key' :	keyForListOfRooms,
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
					api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users, successCallback, errorCallback);
				}
			});
		} else {
			console.log("Warning: First room not found even though there were rooms a moment ago for cityId: " + cityId);
			
			api_createChatRoom(cityId, defaultRoomName, defaultRoomTopic, extraDataString, type, users, successCallback, errorCallback);
		}
	});
} // end api_getDefaultRoomId()

/**
 * Create a chat room on the given wiki with the given name and topic, and return its roomId.
 *
 * The 'extraDataString' is a json string of a hash of data which should be stored in the 'room'
 * object for use in the chat server later.
 */
function api_createChatRoom(cityId, roomName, roomTopic, extraDataString, type, users, successCallback, errorCallback) {
	var roomId = "";

	// Get the next id that a new room should have.
	rc.incr(config.getKey_nextRoomId(), function(err, roomId){
		if (err) {
			var errorMsg = 'Error: while getting length of list of rooms for wiki with cityId "'+ cityId + '": ' + err;
			console.log(errorMsg);
			errorCallback(errorMsg);
		} else {
			// Create the room.
			var roomKey = config.getKey_room( roomId );
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
				'wgCityId': cityId,
				'wgServer': extraData.wgServer,
				'wgArticlePath': extraData.wgArticlePath
			});

			// Add the room to the list of rooms on this wiki.
			rc.rpush(config.getKey_listOfRooms(cityId, type, users), roomId);

			var result = {
				'roomId': roomId,
				'roomName': roomName,
				'roomTopic': roomTopic
			};
			successCallback(result);

			if(type == 'private') {
				for(var index in users){
					rc.hset( config.getKey_usersAllowedInPrivRoom( roomId ) , users[index], users[index], function(err, data){
						if (err) {
							var errorMsg = 'Error: when save users list of chat room "'+ cityId + '": ' + err;
							console.log(errorMsg);
							errorCallback(errorMsg);
							return true;
						}
					});
				}

			}
		}
	});
} // end api_createChatRoom()

/**
 * Given a roomId, returns the cityId which it has in redis (as JSON).
 */
function api_getCityIdForRoom(roomId, successCallback, errorCallback){
	
	rc.hget(config.getKey_room(roomId), 'wgCityId', function(err, cityId){
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
	rc.hkeys(config.getKey_usersInRoom(roomId), function(err, users){
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

/**
 * Returns some JSON of stats about the server (to help judge the usage-level for making scaling estimations).
 */
function api_getRoomsList(successCallback, errorCallback){
	var test = [];
	rc.keys(config.getKey_room("*"), function(err, roomKeys){
		test.push( roomKeys );
			for(var index in roomKeys){
				test.push( roomKeys[index] );	
				rc.hgetall( 'room:13' , function(err, data) {	
					test.push( data );	
					successCallback( test );
				});
		}
	});
}
/**
 * Returns some JSON of stats about the server (to help judge the usage-level for making scaling estimations).
 */
function api_getStats(successCallback, errorCallback){

	console.log("== GETTING DETAILED STATS ABOUT THE STATE OF THE SERVER ==");

	var stats = {
		totalRooms: 0,
		roomsWithOccupants: 0,
		totalConnectedUsers: 0,
		usersInMostPopularRoom: 0,
		mostPopularRoom: {} // will contain the hash of data about the most popular room.
	};

	// Find total number of rooms.
	console.log("STATS: FINDING NUMBER OF ROOMS...");
	rc.keys(config.getKey_room("*"), function(err, roomKeys){
		if (err) {
			var errorMsg = 'Error: while getting all rooms: ' + err;
			console.log(errorMsg);
			errorCallback(errorMsg);
		} else {
			// Count the rooms that have been created on this server (many may be empty).
			var totalRooms = 0, key;
			for (key in roomKeys) {
				if (roomKeys.hasOwnProperty(key)){
					totalRooms++;
				}
			}
			stats.totalRooms = totalRooms;

			// Iterate through rooms and find number of occupants total (and track number of rooms which have > 0 users in them right now).
			var roomsWithOccupants = 0;
			var totalConnectedUsers = 0;
			var usersInMostPopularRoom = 0;
			var mostPopularRoomKey = "";
			console.log("STATS: FINDING OCCUPANTS PER ROOM & RELATED STATS...");
			rc.keys(config.getKey_usersInRoom("*"), function(err, usersInRoomKeys){
				if (err) {
					var errorMsg = 'Error: while getting all users_in_room keys: ' + err;
					console.log(errorMsg);
					errorCallback(errorMsg);
				} else {
					if(usersInRoomKeys.length == 0){
						console.log("STATS: No users in any rooms yet.");
						errorCallback("There are no users in any rooms at the moment.");
					} else {

						// Die for now... these stats are all wrong because of race-conditions.
						console.log("STATS: ");
						console.log(stats);
						successCallback( stats );
					
						// NOTE: this won't work because the redis calls are async, so they're going in paraallel. It gets quite wrong quite fast.
						// NEED TO DO IT A DIFFERENT WAY... Perhaps have a queue of rooms to check, then recursively check one, dequeue it, then recursively call the same function on the remainder of the queue.
						/*
						console.log("STATS: Found " + usersInRoomKeys.length + " room keys.");
						for (var index = 0; index < usersInRoomKeys.length; index++){
							var usersInRoomKey = usersInRoomKeys[index];
							console.log("STATS: Looking for number of users in roomkey: " + usersInRoomKey + " (index=" + index + ").");
							rc.hlen(usersInRoomKey, function(err, numUsersInRoom){
								console.log("STATS: Roomkey " + usersInRoomKey + " has " + numUsersInRoom + " users in it (index=" + index + ").");
								if (err) {
									var errorMsg = 'Error: while getting number of users in room with key: ' + numUsersInRoom + ' ...error was: '+ err;
									console.log(errorMsg);
									errorCallback(errorMsg);
								} else if(numUsersInRoom && (numUsersInRoom > 0)){
									roomsWithOccupants++;
									totalConnectedUsers += numUsersInRoom;
									if(numUsersInRoom > usersInMostPopularRoom){
										console.log("There were " + usersInMostPopularRoom + " users in room " + mostPopularRoomKey + " but there are " + numUsersInRoom + " in " + usersInRoomKey);
										usersInMostPopularRoom = numUsersInRoom;
										mostPopularRoomKey = usersInRoomKey;
									}
								}
								
								// If this is the last key in the array, do the follow-up processing.
								if(index + 1 >= usersInRoomKeys.length){
									// Find the info about the most popular room.
									mostPopularRoomKey = mostPopularRoomKey.replace(new RegExp(config.getKeyPrefix_usersInRoom()), config.getKeyPrefix_room()); // convert from users_in_room key to key for info about room.
									console.log("STATS: FINDING INFO ABOUT THE MOST POPULAR ROOM (" + mostPopularRoomKey + ")...");
									rc.hgetall(mostPopularRoomKey, function(err, roomData){
										if (err) {
											var errorMsg = 'Error: while getting room information about most popular room with key: ' + mostPopularRoomKey + ' ...error was: '+ err;
											console.log(errorMsg);
											errorCallback(errorMsg);
										} else {
											stats.mostPopularRoom = roomData;
										}
										
										stats.roomsWithOccupants = roomsWithOccupants;
										stats.totalConnectedUsers = totalConnectedUsers;
										stats.usersInMostPopularRoom = usersInMostPopularRoom;
										console.log("STATS: ");
										console.log(stats);
										successCallback( stats );
									});
								}
							});
						}
						*/
					}
				}
			});
		}
	});
} // end api_getStats()
