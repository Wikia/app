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
var redis = require('redis');
var rc = redis.createClient();
rc.on('error', function(err) {
    console.log('Error ' + err);
});

// Create the API server (which fills requests from the MediaWiki server).
http.createServer(function (req, res) {
	var reqData = urlUtil.parse(req.url, true);
	apiDispatcher(req, res, reqData, function(result){
		resg = res; // macbre: is this variable needed?
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
}function api_getRedisStats(callback) {
	var stats = [];
	rc.info(function(err, data){
		if (err) {
			console.log(err);
			errorCallback(err);
		} else {
			var data = data.split("\r\n");
			for(var i = 0; i < data.length; i++){
				var temp = data[i].split(":");
				if(temp.length == 2){
					stats[temp[0]] = temp[1];
				}
			}

			// Holy log-spam batman! :)
			//console.log(stats);

			if(data.indexOf('allocation_stats')) {
				callback(stats);
			}
		}
	});
}

/**
 * get cpu % usege
 */

function getCpuPused(pid, callback) {
	var sys = require('sys')
	var exec = require('child_process').exec;
	var puts = function(error, stdout, stderr) { callback(parseFloat(stdout)) }
	var com = "ps -opcpu -p " + pid + " | grep -v CPU";
	//console.log( com );
	exec(com, puts);
}

/**
 * Returns some JSON of stats about the server (to help judge the usage-level for making scaling estimations).
 */
function api_getStats(successCallback, errorCallback){
	var out = {};
	out.node_heapTotal = process.memoryUsage().heapTotal;
	out.node_heapUsed = process.memoryUsage().heapUsed;

	api_getRedisStats(function(data){
		var redis_pid = data.process_id;
		out.redis_used_memory = data.used_memory;
		out.redis_used_memory_rss = data.used_memory_rss;
		out.redis_mem_fragmentation_ratio = parseFloat(data.mem_fragmentation_ratio);
		out.redis_uptime_in_days = data.uptime_in_days;
		out.redis_used_cpu_sys = data.used_cpu_sys;
		out.redis_used_cpu_user = data.used_cpu_user;
		out.redis_used_cpu_by_days = (out.redis_used_cpu_sys + out.redis_used_cpu_user)/out.redis_uptime_in_days;

		rc.hgetall(config.getKey_runtimeStats(), function(err, data){
			if(err) {
				errorCallback(err);
				return ;
			}
			out.runtime = (parseInt(new Date().getTime()) - parseInt(data.laststart) + parseInt(data.runtime) );
			out.avg_runtime = out.runtime/(parseInt(data.startcount) + 1);
			rc.hget(config.getKey_userCount(), 'count', function(err, data){
				if(err) {
					errorCallback(err);
					return ;
				}
				out.usercount = data;

				getCpuPused( process.pid, function(cpu) {
					out.node_cpup = cpu;
					getCpuPused( redis_pid, function(cpu) {
						out.redis_cpup = cpu;
						successCallback(out);
					});
				});

			});
		});

	});
} // end api_getStats()