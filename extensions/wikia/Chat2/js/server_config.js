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

arvg.instance = arvg.instance - 1;
var chatConfig = JSON.parse(fs.readFileSync(process.env.WIKIA_CONFIG_ROOT + '/ChatConfig.json'));

var instaceNumber = chatConfig[arvg.mode]['MainChatServers'][arvg.basket].length;


var chatServer = chatConfig[arvg.mode]['MainChatServers'][arvg.basket][arvg.instance].split(':');
var apiServer = chatConfig[arvg.mode]['ApiChatServers'][arvg.basket][arvg.instance].split(':');


exports.FLASH_POLICY_PORT = 10843 + arvg.instance;
exports.CHAT_SERVER_HOST = chatServer[0];
exports.CHAT_SERVER_PORT = parseInt(chatServer[1]);

exports.BASKET = arvg.basket;
exports.INSTANCE = arvg.instance + 1;
exports.API_SERVER_HOST = apiServer[0];
exports.API_SERVER_PORT = parseInt(apiServer[1]);

var redisServer = chatConfig[arvg.mode]['RedisServer'][arvg.basket].split(':');

exports.REDIS_HOST = redisServer[0];
exports.REDIS_PORT = redisServer[1];

// Settings for local varnish
exports.WIKIA_PROXY = chatConfig[arvg.mode]['ProxyServer'];

/** CONSTANTS **/
exports.MAX_MESSAGES_IN_BACKLOG = chatConfig['MaxMessagesInBacklog']; // how many messages each room will store for now. only longer than NUM_MESSAGES_TO_SHOW_ON_CONNECT for potential debugging.
exports.MAX_MESSAGES_IN_BACKLOG = chatConfig['NumMessagesToShowOnConnect'];

exports.TOKEN = chatConfig['ChatCommunicationToken'];

exports.validateConnection = function(cityId) {
	//TODO: take this out when we will be operating on 2 servers
	return true;
	if(typeof arvg.instance != 'undefined') {
		if(arvg.instance == cityId%instaceNumber){
			return true;
		}
		return false;
	}
	return false;
}

exports.validateActiveBasket = function(basket) {
	//TODO: take this out when we will be operating on 2 servers
	return true;

	if(typeof arvg.basket != 'undefined') {
		if(arvg.basket == basket){
			return true;
		}
		return false;
	}
	return false;
}

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


exports.getKey_userCount = function(){ return "UserCounts_" + exports.INSTANCE; }
exports.getKey_runtimeStats = function(){ return "runtimeStats_"  + exports.INSTANCE; }

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
