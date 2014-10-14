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
var lastTs = 0;
//process.uptime()


/*
* @author Tomasz Odrobny
*
* send data to event tracing server
*
*/

var send = function(data) {
	data.track_id = trackId;

	var ts = Math.round((new Date()).getTime() / 1000);
	trackId++;

	if(trackId > 255 && lastTs != ts) {  //do not restart the clock in the some secone
		trackId = 0;
	}
	lastTs = ts;
	data.ts = ts;
	data.beacon = '0000000000';

	var url =  'http://a.wikia-beacon.com/__track/special/chat-event?' + qs.stringify(data);
	logger.info(url);
	request({
			method: "GET",
			headers: {'content-type' : 'application/x-www-form-urlencoded'},
			body: "",
			json: false,
			url: url
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
		"username": client.username,
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
