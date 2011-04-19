var WIKIA_NODE_HOST = "http://chatserver.wikia-dev.com";
var WIKIA_NODE_PORT = 8000;
io = require('../socket.io/socket.io.js');
//var io = require('socket.io');
Backbone = require('backbone');
var models = require('../models/models.js');
//var views = require('../views/views.js');

//
//Controllers
//
var NodeChatController = {
	init: function() {
		this.socket = new io.Socket(WIKIA_NODE_HOST, {port: WIKIA_NODE_PORT});
		var mySocket = this.socket;

		this.model = new models.NodeChatModel();
//		this.view = new NodeChatView({model: this.model, socket: this.socket, el: $('body')});
//		var view = this.view;
		this.connected = false;
		this.announceConnection = false; // we only announce the connection for reconnections

//		this.socket.on('message', function(msg) {view.msgReceived(msg)});
		this.socket.on('message', function(msg) {
			NodeChatHelper.log("GOT MESSAGE: " + msg);
		});
		
		this.socket.on('connect', function() { 
            if(NodeChatController.announceConnection){
				inlineAlert(NodeChatController.model, 'Reconnected!'); // TODO: i18n: how do we do i18n for this?
				NodeChatController.announceConnection = false;
			}
            NodeChatController.connected = true;
//            //view.setConnected(true);
        }); 

		//Try to reconnect if we get disconnected (and inform the user of what is going on).
        this.socket.on('disconnect', function(){
			inlineAlert(NodeChatController.model, 'Disconnected from the chat server. Uh oh!'); // TODO: i18n: how do we do i18n for this?
            NodeChatController.connected = false;
			NodeChatController.announceConnection = true;
//            //view.setConnected(false);
			
			// Sometimes the view is in a state where it shouldn't reconnected (eg: user has entered the same room from another computer and wants to kick this instance off w/o it reconnecting).
			if(NodeChatController.view.autoReconnect){
				trying = setTimeout(tryconnect,500);
			}
        });
        function tryconnect(){
            if(!NodeChatController.connected) {
				inlineAlert(NodeChatController.model, "Trying to reconnect..."); // TODO: i18n: how do we do i18n for this?
                mySocket.connect();
                clearTimeout(trying);
                trying = setTimeout(tryconnect,30000);
            }
        }

		this.socket.connect();

//		this.view.render();

		return this;
	}
};

/**
 * Helper function for displaying an inline alert.
 */
function inlineAlert(model, msg){
	var newAlert = new models.InlineAlert({text: msg});
	model.chats.add(newAlert);
} // end inlineAlert()

//
// Bootstrap the app
//
//$(function() {
	var app = NodeChatController.init({});
	NodeChatHelper.init();
//});
