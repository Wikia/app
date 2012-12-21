/*
* @author Tomasz Odrobny
*
* This file contains simple tracking system for chat server side events
*
*/

var config = require("./server_config.js");
var qs = require('qs');
var request = require('request');
//process.uptime()


export.trackEvent = function(user) {
	var data = {
		"test" : "test1"
	};

	request({
		method: "GET",
		headers: {'content-type' : 'application/x-www-form-urlencoded'},
		body: "",
		json: false,
		url: "http://a.wikia-beacon.com/__track/special/chatevent?"+ qs.stringify(data),
		proxy: 'http://' + config.WIKIA_PROXY
	},
	function (error, response, body) {

	});
}