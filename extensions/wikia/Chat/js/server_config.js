/**
 * @author Sean Colombo
 *
 * This file contains config that will be used by both the node chat server and the Node Chat API.
 */

/** CONSTANTS **/
exports.CHAT_SERVER_PORT = 8000;
exports.API_SERVER_PORT = 8001;
exports.MAX_MESSAGES_IN_BACKLOG = 50; // how many messages each room will store for now. only longer than NUM_MESSAGES_TO_SHOW_ON_CONNECT for potential debugging.
exports.NUM_MESSAGES_TO_SHOW_ON_CONNECT = 10;
exports.AUTH_URL = "/?action=ajax&rs=ChatAjax&method=getUserInfo"; // do NOT add hostname into this URL.
exports.KICKBAN_URL = "/?action=ajax&rs=ChatAjax&method=kickBan";
exports.GIVECHATMOD_URL = "/?action=ajax&rs=ChatAjax&method=giveChatMod";
exports.WIKIA_PROXY_HOST = "";
exports.WIKIA_PROXY_PORT = "";

// Settings for local varnish
exports.WIKIA_PROXY_HOST = "127.0.0.1";
exports.WIKIA_PROXY_PORT = 6081;


/** KEY BUILDING / ACCESSING FUNCTIONS **/
exports.getKey_listOfRooms = function(cityId){ return "rooms_on_wiki:" + cityId; }
exports.getKey_nextRoomId = function(){ return "next.room.id"; }
exports.getKeyPrefix_room = function(){ return "room"; }
exports.getKey_room = function(roomId){ return exports.getKeyPrefix_room() + ":" + roomId; }
exports.getKey_userInRoom = function(userName, roomId){
	// Key representing the presence of a single user in a specific room (that user may be in multiple rooms).
	// used by the in-memory sessionIdByKey hash, not by redis.. so not prefixed.
	return roomId + ":" + userName;
}
exports.getKeyPrefix_usersInRoom = function(){ return "users_in_room"; }
exports.getKey_usersInRoom = function(roomId){ return exports.getKeyPrefix_usersInRoom() +":" + roomId; } // key for set of all usernames in the given room
exports.getKey_chatEntriesInRoom = function(roomId){ return "chatentries:" + roomId; }
