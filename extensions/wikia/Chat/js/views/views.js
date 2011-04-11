
//
//Views
//

// TODO: REFACTOR THIS TO BE ONE VIEW FOR CHATS!!!! There can be a template and a template_inline & render can choose based on the model type.  Then remove the clutter of the other View type from everywhere.
// TODO: REFACTOR THIS TO BE ONE VIEW FOR CHATS!!!! There can be a template and a template_inline & render can choose based on the model type.  Then remove the clutter of the other View type from everywhere.


var ChatView = Backbone.View.extend({
	tagName: 'li',
	template: _.template( $('#message-template').html() ),
	inlineTemplate: _.template( $('#inline-alert-template').html() ),

	initialize: function(options) {
		_.bindAll(this, 'render');
		this.model.bind('all', this.render);
	},

	render: function(){
		//NodeChatHelper.log("ABOUT TO RENDER THIS CHAT MESSAGE: " + JSON.stringify(this.model));
		if(this.model.get('isInlineAlert')){
			var originalTemplate = this.template;
			this.template = this.inlineTemplate;
			$(this.el).html(this.template(this.model.toJSON()));
			this.template = originalTemplate;
		} else {
			$(this.el).html(this.template(this.model.toJSON()));
		}
		
		if(this.model.get('isInlineAlert') === true){
			$(this.el).addClass('inline-alert');
		}

		return this;
	}
});

var UserView = Backbone.View.extend({
	tagName: 'li',
	template: _.template( $('#user-template').html() ),

	/*
	events: {
		"click .kickban"            : "toggleDone",
	},
	*/

	initialize: function(){
		_.bindAll(this, 'render', 'close');
		this.model.bind('change', this.render);
		this.model.view = this;
	},

	render: function(){
		//NodeChatHelper.log("ABOUT TO RENDER THIS USER: " + JSON.stringify(this.model));
		$(this.el).html( this.template(this.model.toJSON()) );
		
		// Set the id by username so that we can remove it when the user parts.
		$(this.el).attr('id', NodeChatHelper.liIdByUsername( this.model.get('name') ));

		// If this is a chat moderator, add the chat-mod class so that kick-ban links don't show up, etc.
		if(this.model.get('isModerator') === true){
			$(this.el).addClass('chat-mod');
		}

		return this;
	}
});

var NodeChatView = Backbone.View.extend({
	initialize: function(options) {
		this.autoReconnect = true;
		this.model.chats.bind('add', this.addChat);
		this.model.users.bind('add', this.addUser);
		this.model.users.bind('remove', this.removeUser);
		this.model.users.bind('all', this.beautifyUserList);
		
	//	this.model.users.bind('all', function(eventName){ // just a wrapper which outputs the event to the console.
	//		NodeChatHelper.log("User list event: " + eventName);
	//		object.trigger(eventName); // call actual handler.
	//	});

		this.socket = options.socket;
		//this.clientCountView = new ClientCountView({model: new models.ClientCountModel(), el: $('#client_count')});
		$(window).focus(function() {
			// set focus on the text input
			NodeChatHelper.focusTextInput();
		});
	},

	events: {
		"submit #Write": "sendMessage",
		"click a.kickban": "kickBan"
	},
	
	// When the user list changes, make sure it is built the way we want (no duplicates, etc.).
	beautifyUserList: function(eventName){
		NodeChatHelper.log("Beautifying the user list...");

		var mylist = $("#Users ul");
		var listitems = mylist.children('li').get();

		listitems.sort(function(a, b) {		
			var compA = $(a).children(".user").text().toUpperCase();
			var compB = $(b).children(".user").text().toUpperCase();
			return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
		})

		mylist.children().remove();

		$.each(listitems, function(idx, itm) {
			if ($("#Users #" + $(itm).attr("id")).length == 0) {
				mylist.append(itm); 
			}
		});	
	},

	addChat: function(chat) {
		// Determine if chat view is presently scrolled to the bottom
		var isAtBottom = false;				
		if (($("#Chat").scrollTop() + 1) >= ($("#Chat ul").outerHeight() - $("#Chat").height())) {
			isAtBottom = true;
		}
		
		// Add message to chat
		var view = new ChatView({model: chat});
		$('#Chat ul').append(view.render().el);

		// Scroll chat to bottom
		if (chat.attributes.name == wgUserName || isAtBottom) {
			NodeChatHelper.scrollToBottom();
		}
	},

	addUser: function(user) {
		var view = new UserView({model: user});
		$('#Users ul').append(view.render().el);
	},
	
	removeUser: function(user) {
		NodeChatHelper.log("Trying to remove " + user.get('name') + " from the list.");
		NodeChatHelper.log("Matches found: " + $('#' + NodeChatHelper.liIdByUsername( user.get('name') )).length);
		$('#' + NodeChatHelper.liIdByUsername( user.get('name') )).remove();
	},

	msgReceived: function(message){
		switch(message.event) {
			case 'auth':
				// Server has requested that the client send its authentication data (Wikia session cookies).

				// We can't access the second-level-domain cookies from Javascript, so we make a request to wikia's
				// servers (which we trust) to echo back the session info which we then send to node via socket.io
				// (which doesn't reliably get cookies directly from clients since they may be on flash, etc. and
				// there isn't good support for getting cookies anyway).
				var mySocket = this.socket;
				NodeChatHelper.log("Getting full session info from Apache.");
				$.get(wgScript + '?action=ajax&rs=ChatAjax&method=echoCookies', {}, function(data) {
					NodeChatHelper.log("Got full session info from Apache: ");
					NodeChatHelper.log(data);

					var authInfo = new models.AuthInfo({
						'cookie': data,
						'roomId': roomId // this is set in the js by Chat_Index.php
					});
					mySocket.send(authInfo.xport());

					NodeChatHelper.log("Sent auth info");
				});
				break;
			case 'initial':
				this.model.mport(message.data);
				this.beautifyUserList();
				break;
			case 'disableReconnect':
				this.autoReconnect = false;
				break;
			case 'chat:add':
				var newChatEntry;
				var dataObj = JSON.parse(message.data);
				if(dataObj.attrs.isInlineAlert){
					newChatEntry = new models.InlineAlert();
				} else {
					newChatEntry = new models.ChatEntry();
				}
				newChatEntry.mport(message.data);
				this.model.chats.add(newChatEntry);
				break;
			case 'join': // A user joined the chat.
				var joinedUser = new models.User();
				joinedUser.mport(message.joinData);

				// Check to see if the user already exists in the users list:
				var connectedUser = this.model.users.find(function(user){
										return (user.get('name') == joinedUser.get('name'));
									});
				if(typeof connectedUser == "undefined"){
					this.model.users.add(joinedUser);
				}
				break;
			case 'part': // A user left the chat.
				var partedUser = new models.User();
				partedUser.mport(message.data);
				var connectedUser = this.model.users.find(function(user){
										return user.get('name') == partedUser.get('name');
									});
				if(typeof connectedUser != "undefined"){
					this.model.users.remove(connectedUser);
				}
				break;
			default:
				NodeChatHelper.log("UNRECOGNIZED EVENT IN views.js:msgRecieved: " + message.event);
				break;
		}
	},

	sendMessage: function(){
		var inputField = $('input[name=message]');
		var nameField = $('input[name=user_name]');
		if (inputField.val()) {
			var chatEntry = new models.ChatEntry({name: nameField.val(), text: inputField.val()});
			this.socket.send(chatEntry.xport());
			inputField.val('');
		}
		NodeChatHelper.focusTextInput();		
	},

	kickBan: function(e){
		var userToBan = $(e.target).parent().find('.user').html();
		NodeChatHelper.log("Attempting to kickban user: " + userToBan);
		var kickBanCommand = new models.KickBanCommand({userToBan: userToBan});
		this.socket.send(kickBanCommand.xport());

		// TODO: LATER: Some sort of indicator that the ban is underway. 50% opacity on the user's li?
		// TODO: LATER: Some sort of indicator that the ban is underway. 50% opacity on the user's li?
	}
});

NodeChatHelper = {
	init: function() {
		// Make links open in the parent window
		$("#Chat").find("a").live("click", function(event) {
			event.preventDefault();
			window.open($(this).attr("href"));
		});
		// Focus on the text input
		NodeChatHelper.focusTextInput();
	},
	
	scrollToBottom: function() {
		$("#Chat").scrollTop($("#Chat").get(0).scrollHeight);	
	},
	
	log: function(msg){
		if (typeof console != 'undefined') {
			console.log(msg);
		}
	},

	liIdByUsername: function(username){
		username = username.replace(/ /g, "_"); // encodeURIComponent would add invalid characters
		return 'user-' + username;
	},

	focusTextInput: function() {
		$("#Write").find('input[type="text"]').focus();
	}	
};
