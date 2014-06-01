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
var storage = require('./storage').redisFactory();
var logger = require('./logger').logger;

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
		};
		res.write( JSON.stringify(errorData ) );
		res.end();
	});

}).listen(config.API_SERVER_PORT, config.API_SERVER_HOST, function(data) {
	logger.info("API server running on " + config.API_SERVER_HOST + ':' + config.API_SERVER_PORT);
});

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

			api_getDefaultRoomId(
				reqData.query.wgCityId,
				reqData.query.extraDataString,
				reqData.query.roomType,
				reqData.query.roomUsers,
				successCallback,
				errorCallback
			);

		} else if(func == "getcityidforroom"){
			api_getCityIdForRoom(reqData.query.roomId, successCallback, errorCallback);
		} else if(func == "getusersinroom"){
			api_getUsersInRoom(reqData.query.roomId, successCallback, errorCallback);
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
 * If the chat doesn't exist, creates it.
 *
 * As per the API convention, passes json on success to the successCallback or an error message (a string) to
 * the errorCallback on error.
 */
function api_getDefaultRoomId(cityId, extraDataString, type, serializedUsers, successCallback, errorCallback){
	// See if there are any rooms for this wiki and if there are, get the first one.
	var roomId = "";

	users = [];
	if ( typeof(serializedUsers) != 'undefined' ) {
		try {
			users = JSON.parse( serializedUsers ) || [];
		} catch(err) {}
	}

	var createRoom = function() {
		api_createChatRoom(cityId, extraDataString, type, users, successCallback, errorCallback);
	};
	
	storage.getListOfRooms(cityId, type, users,
		function(roomIds) {
			if(roomIds){
				// For now, if there is more than one wiki in the room, we just grab the first as the default room.
				roomId = roomIds[0];
				storage.getRoomData(roomId, null,
					function(roomData) {
						var result = {
							'type' : users,
							'roomId': roomId
						};
						successCallback(result);
					},
					createRoom
				);
				
			} else {
				// No luck loading the room... create it.
				createRoom();
			}
		},
		createRoom
	);	
} // end api_getDefaultRoomId()

/**
 * Create a chat room on the given wiki with the given name and topic, and return its roomId.
 *
 * The 'extraDataString' is a json string of a hash of data which should be stored in the 'room'
 * object for use in the chat server later.
 */
function api_createChatRoom(cityId, extraDataString, type, users, successCallback, errorCallback) {
	storage.createChatRoom(cityId, extraDataString, type, users, successCallback, errorCallback);
	
} // end api_createChatRoom()

/**
 * Given a roomId, returns the cityId which it has in redis (as JSON).
 */
function api_getCityIdForRoom(roomId, successCallback, errorCallback){
	storage.getRoomData(roomId, 'wgCityId', function(value) {
		var result = {
			'cityId': value
		};
		successCallback(result);
	}, errorCallback);
} // end api_getCityIdForRoom()
