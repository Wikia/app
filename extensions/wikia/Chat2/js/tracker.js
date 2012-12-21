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
//process.uptime()


exports.trackEvent = function(user) {
	var data = {
		"test" : "test1"
	};

	logger.info('http://' + config.WIKIA_PROXY);
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
