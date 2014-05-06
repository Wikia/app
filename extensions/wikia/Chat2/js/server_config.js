/**
 * @author Sean Colombo
 *
 * This file contains config that will be used by both the node chat server and the Node Chat API.
 */

var md5 = require("./lib/md5.js").md5;
var os = require('os');

var arvg = {};

process.argv.forEach(function (val, index, array) {
	var arv = val.split('=');
	arvg[arv[0]] = arv[1];
});

console.log(arvg);

//Load the configuration from media wiki conf

var dns = require('dns');
var fs = require('fs');

var chatConfig = JSON.parse(fs.readFileSync(process.env.WIKIA_CONFIG_ROOT + '/ChatConfig.json'));

var chatServer = chatConfig[arvg.mode]['MainChatServer'].split(':');
var apiServer = chatConfig[arvg.mode]['ApiChatServer'].split(':');

exports.FLASH_POLICY_PORT = 10843;

exports.CHAT_SERVER_HOST = chatServer[0];
exports.CHAT_SERVER_PORT = parseInt(chatServer[1]);

exports.API_SERVER_HOST = apiServer[0];
exports.API_SERVER_PORT = parseInt(apiServer[1]);

var redisServer = chatConfig[arvg.mode]['RedisServer'].split(':');

exports.REDIS_HOST = redisServer[0];
exports.REDIS_PORT = redisServer[1];

// Settings for local varnish
exports.WIKIA_PROXY = chatConfig[arvg.mode]['ProxyServer'];

/** CONSTANTS **/
exports.MAX_MESSAGES_IN_BACKLOG = chatConfig['MaxMessagesInBacklog']; // how many messages each room will store for now. only longer than NUM_MESSAGES_TO_SHOW_ON_CONNECT for potential debugging.
exports.NUM_MESSAGES_TO_SHOW_ON_CONNECT = chatConfig['NumMessagesToShowOnConnect'];

exports.TOKEN = chatConfig['ChatCommunicationToken'];

exports.logLevel = (typeof arvg.loglevel != 'undefined') ? arvg.loglevel : "CRITICAL" ;

//TODO move this to other file
/** KEY BUILDING / ACCESSING FUNCTIONS **/
exports.getKey_listOfRooms = function( cityId, type, users ){
	if(type == "open") {
		return "rooms_on_wiki:" + cityId;
	} else {
		users = users || [];
		users = users.sort();
		return "rooms_on_wiki:" + cityId + ':' + md5( type + users.join( ',' ) );
	}
}

exports.getKey_nextRoomId = function(){ return "next.room.id"; }
exports.getKeyPrefix_room = function(){ return "room"; }


exports.getKey_userCount = function(){ return "UserCounts"; }
exports.getKey_runtimeStats = function(){ return "runtimeStats"; }

exports.getKey_sessionData = function(key){ return "session_data:" + key; }

exports.getKey_room = function(roomId){ return exports.getKeyPrefix_room() + ":" + roomId; }
exports.getKey_userInRoom = function(userName, roomId){
	// Key representing the presence of a single user in a specific room (that user may be in multiple rooms).
	// used by the in-memory sessionIdByKey hash, not by redis.. so not prefixed.
	return roomId + ":" + userName;
}

exports.getKeyPrefix_usersInRoom = function(){ return "users_in_room"; }
exports.getKey_usersInRoom = function(roomId){ return exports.getKeyPrefix_usersInRoom() +":" + roomId; } // key for set of all usernames in the given room

exports.getKeyPrefix_usersAllowedInPrivRoom = function(){ return "users_allowed_in_priv_room"; }
exports.getKey_usersAllowedInPrivRoom = function( roomId ){ return exports.getKeyPrefix_usersAllowedInPrivRoom() + ":" + roomId; }

exports.getKey_chatEntriesInRoom = function(roomId){ return "chatentries:" + roomId; }
