/*
* @author Tomasz Odrobny
*
* This file contains simple tracking system for chat server side events
*
*/

var config = require("./server_config.js");
var qs = require('qs');
var request = require('request');
var logger = require('./logger.js').logger;
var trackId = 0;
//process.uptime()


/*
* @author Tomasz Odrobny
*
* send data to event tracing server
*
*/

var send = function(data) {
	data.track_id = trackId;
	trackId++;
	if(trackId > 255) {
		trackId = 0;
	}

	var ts = Math.round((new Date()).getTime() / 1000);
	data.ts = ts;

	var url =  'http://a.wikia-beacon.com/__track/special/chatevent?' + qs.stringify(data);
	logger.info(url);
	request({
			method: "GET",
			headers: {'content-type' : 'application/x-www-form-urlencoded'},
			body: "",
			json: false,
			url: url,
		},
		function (error, response, body) {
			logger.info(body)
		});
}


/*
 * @author Tomasz Odrobny
 *
 * track server start
 *
 */

exports.trackServerStart = function() {
	var data = {
		"action": "server_start",
		"server_id": config.INSTANCE
	};

	send(data);
}

/*
 * @author Tomasz Odrobny
 *
 * track connect/disconnect/logout
 *
 */

exports.trackEvent = function(client, action) {
	var data = {
		"userkey": client.userKey,
		"msgcount": client.msgCount,
		"room_id": client.roomId,
		"city_id": client.cityId,
		"privateroom": client.privateRoom,
		"action": action,
		"server_id": config.INSTANCE
	};

	send(data);
}
