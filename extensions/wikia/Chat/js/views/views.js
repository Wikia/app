
//
//Views
//

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
		
		// Add username as a class in li element
		if (this.model.get('name') == wgUserName) {
			$(this.el).addClass('you');
		}
		
		// Inline Alert
		if(this.model.get('isInlineAlert') === true){
			$(this.el).addClass('inline-alert');
		}

		return this;
	}
});

var UserView = Backbone.View.extend({
	tagName: 'li',
	className: 'User',
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
		
		// If the user is away, add a certain class to them, if not, remove the away class.
		if(this.model.get('statusState') == STATUS_STATE_AWAY){
			$(this.el).addClass('away');
		} else {
			$(this.el).removeClass('away');
		}
		
		// If this is you, render your content on top.
		if( this.model.get('name') == wgUserName ){
			NodeChatHelper.log("Attempting to render self. Copying up to other div.");
			$(this.el).css('display', 'none');
			$('#ChatHeader .User').html( $(this.el).html() )
								  .attr('class', $(this.el).attr('class') );
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
		"click .kickban": "kickBan"
	},
	
	// When the user list changes, make sure it is built the way we want (no duplicates, etc.).
	beautifyUserList: function(eventName){
		NodeChatHelper.log("Beautifying the user list...");

		var mylist = $("#Users > ul");
		var listitems = mylist.children('li').get();

		listitems.sort(function(a, b) {		
			var compA = $(a).children(".username").text().toUpperCase();
			var compB = $(b).children(".username").text().toUpperCase();
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
		$('#Users > ul').append(view.render().el);
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
						'name': wgUserName, // for debugging only
						'cookie': data,
						'roomId': roomId // this is set in the js by Chat_Index.php
					});
					mySocket.send(authInfo.xport());

					NodeChatHelper.log("Sent auth info");
				});
				break;
			case 'initial':
				this.model.mport(message.data);
				//this.beautifyUserList(); // now attached to all changes
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
			case 'updateUser': // A user in the room changed (eg: their status changed)
				var updatedUser = new models.User();
				updatedUser.mport(message.data);
				var connectedUser = this.model.users.find(function(user){
										return user.get('name') == updatedUser.get('name');
									});
				if(typeof connectedUser != "undefined"){
					// Is this the right way to do it?
					this.model.users.remove(connectedUser);
					this.model.users.add(updatedUser);
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
	
	// Set the current user's status to 'away' and set an away message if provided.
	setAway: function(){
		var msg = '';
		//var msg = $(e.target).parent().find('.user').html();
		//if(!msg){msg = '';}
		NodeChatHelper.log("Attempting to go away with message: " + msg);
		var setStatusCommand = new models.SetStatusCommand({
			statusState: STATUS_STATE_AWAY,
			statusMessage: msg
		});
		this.socket.send(setStatusCommand.xport());
	},
	
	// Set the user as being back from their "away" state (they are here again) and remove the status message.
	setBack: function(){
		NodeChatHelper.log("Attempting to come BACK from away.");
		var setStatusCommand = new models.SetStatusCommand({
			statusState: STATUS_STATE_PRESENT,
			statusMessage: ''
		});
		this.socket.send(setStatusCommand.xport());
	},

	kickBan: function(e){
		e.preventDefault();
		var userToBan = $(e.target).closest('.UserStatsMenu').find('.username').text();
		NodeChatHelper.log("Attempting to kickban user: " + userToBan);
		var kickBanCommand = new models.KickBanCommand({userToBan: userToBan});
		this.socket.send(kickBanCommand.xport());

		$("#UserStatsMenu").hide();

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

		// Handle user stats menu
		NodeChatHelper.userStatsMenuInit();
		
		// Handle Away status
		$(window)
			.mousemove(NodeChatHelper.resetActivityTimer)
			.keypress(NodeChatHelper.resetActivityTimer)
			.focus(NodeChatHelper.resetActivityTimer);
	},
	
	startActivityTimer: function() {
		NodeChatHelper.activityTimer = setTimeout(NodeChatHelper.setAway, 5 * 60 * 1000); // the first number is minutes.
	},

	resetActivityTimer: function() {
		clearTimeout(NodeChatHelper.activityTimer);
		NodeChatHelper.startActivityTimer();
		
		// If user had been set to away, ping server to unset away.
		if($('#ChatHeader .User').hasClass('away')){
			NodeChatHelper.setBack();
		}
	},
	
	setAway: function() {
		NodeChatHelper.log("Telling the server that I'm away.");
		NodeChatController.view.setAway();
	},
	
	setBack: function() {
		NodeChatHelper.log("Telling the server that I'm back.");
		NodeChatController.view.setBack();
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
	},	
	
	userStatsMenuInit: function() {
		$('#Users li').live('click', function() {
			var menu = $("#UserStatsMenu");
			menu
				.html($(this).find('.UserStatsMenu').html())
				.css('left', $(this).offset().left - menu.outerWidth() + 10)
				.css('top', $(this).offset().top);
			
			// Is the menu falling below the viewport? If so, move it!				
			if (parseInt(menu.css('top')) + menu.outerHeight() > $(window).height()) {
				menu.css('top', $(window).height() - menu.outerHeight());
			}
			
			// Add chat-mod class if necessary
			($(this).hasClass('chat-mod')) ? menu.addClass('chat-mod') : menu.removeClass('chat-mod');
			
			menu.show();

			// Bind event handler to body to close the menu			
			$('body').bind('click.menuclose', function(event) {
				if (!$(event.target).closest('#UserStatsMenu').length) {
					$('#UserStatsMenu').hide();
					$('body').unbind('.menuclose');
				};
			});
			
			// Handle clicking the profile and contrib links
			menu.find('.profile').add('.contribs').click(function(event) {
				event.preventDefault();
				var target = $(event.currentTarget);
				var menu = target.closest('.UserStatsMenu');
				var username = menu.find('.username').text();
				var location = '';
				
				if (target.hasClass('profile')) {
					location = pathToProfilePage.replace('$1', username);
				} else if (target.hasClass('contribs')) {
					location = pathToContribsPage.replace('$1', username);
				}
								
				window.open(location);
				menu.hide();
			});			
		});
	}
};
