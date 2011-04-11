$(function() {
	Chat.init();
});

var Chat = {
	getCb: function() { return "&cb=" + Math.floor(Math.random()*99999); },
	init: function() {
		$(window)
			.unload(function() {
				// user parts the chat
			// TODO: 
			//	$.ajax({
			//		url: wgScript + '?action=ajax&rs=ChatAjax&method=part&chatId=' + chatId + Chat.getCb(),
			//		async: false
			//	});
			})
			.focus(function() {
				// set focus on the text input
				$("#Write").find('input[type="text"]').focus();
			});
		
		window.isFocused = true;
		
		// If this user is a ChatMod, set class on body tag
	// Moved to template
	//	if (wgChatMod) {
	//		$("body").addClass("chat-mod");
	//	}
			
		// Inline alert the chat topic
		Chat.inlineAlert({type: 'topic'});


		// Make links open in the parent window
		$("#Chat").find("a").live("click", function(event) {
			event.preventDefault();
			window.open($(this).attr("href"));
		});

		// Store original window title
		Chat.title = $("title").html();		
			
		// Scroll chat
		Chat.scrollToBottom();		
	},

	writeSubmit: function(event) {
		event.preventDefault();
				
		var messageField = $(event.currentTarget).find('input[type="text"]');
		var message = messageField.val();
		
		// Ignore if the message is empty
		if (message == "") {
			return;
		}
		
		// Clear message field
		messageField.val("");

		// Immediately add message to chat
		var chatElement = Chat.addMessage({
				user: wgUserName, 
				message: message.replace("<", "&lt;")
			});
				
		// Send message to server
		var requestObj = {
			'chatId': chatId,
			'message': message
		};
		$.get(wgScript + '?action=ajax&rs=ChatAjax&method=postMessage' + Chat.getCb(), requestObj, function(data) {
			if (data.error) {
				alert(data.error);
				chatElement.remove();
			}
		});
	},
	
	rejoin: function(){
		var requestObj = {
			'chatId': chatId
		};
		$.get(wgScript + '?action=ajax&rs=ChatAjax&method=rejoin' + Chat.getCb(), requestObj, function(data) {
			// Now that we're in the chatroom agian... start to longPoll again
			Chat.longPoll();
		});
	},

	addMessage: function(messageObj) {
		
		// Determine if chat view is presently scrolled to the bottom
		var isAtBottom = false;

		if ($("#Chat").scrollTop() >= ($("#Chat ul").outerHeight() - $("#Chat").height())) {
			isAtBottom = true;
		}

		var newChatElement;

		// Check type of message
		if (messageObj.user) {
			// Process message (activate links, etc)
			var processedMessage = Chat.processMessage(messageObj.message);
						
			// Add user message to chat
			newChatElement = $("#Chat").find("[data-type='user'].template").clone()
				.removeClass("template")
				.find(".user").html(messageObj.user).end()
				.find(".message").html(processedMessage).end();
		} else {
			// Add alert to chat
			newChatElement = $("#Chat").find("[data-type='inline-alert'].template").clone()
				.removeClass("template")
				.addClass("inline-alert")
				.html(messageObj.message);
		}

		// Add message to chat
		newChatElement.appendTo("#Chat ul");
		
		// Scroll chat
		if (messageObj.user == wgUserName || isAtBottom) {
			Chat.scrollToBottom();
		}
		
		return newChatElement;
	},
	
	processMessage: function(message) {
		// Linkify http://links
		var exp = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		message = message.replace(exp, "<a href='$1'>$1</a>");

		// Linkify [[links]]
		var exp = /(\[\[[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]*\]\])/ig;
		message = message.replace(exp, function(match) {			
			var article = match.substr(2, match.length - 4);
			var path = wgServer + wgArticlePath;
			var url = path.replace("$1", article);
			return '<a href="' + url + '">' + article + '</a>';
		});

		return message;
	},

	addUser: function(userData) {
		// Ensure the user isn't in the list already
		if ($("#Users").find('[data-user="' + userData.user + '"]').length == 0) {
			var newUserItem = $("#Users").find(".template").clone()
				.removeClass("template")
				.attr("data-user", userData.user)
				.find(".user").text(userData.user).end()
				.appendTo("#Users ul");

	// Added in the render() in views.js
	//		if (userData.chatmod) {
	//			newUserItem.addClass("chat-mod");
	//		}
		}
		Chat.inlineAlert({
			type: 'join',
			user: userData.user
		});
	},

	removeUser: function(user) {
		$("#Users").find('[data-user="' + user + '"]').remove();
		Chat.inlineAlert({
			type: 'part',
			user: user
		});		
	},

	scrollToBottom: function() {
		var chat = $("#Chat");
		chat.scrollTop(chat.get(0).scrollHeight);
	},

	inlineAlert: function(alertObj) {
		if (alertObj.type == 'topic') {
			Chat.addMessage({message: $("title").html()});
		} else if (alertObj.type == 'join') {
			Chat.addMessage({message: alertObj.user + " has joined the chat"});
		} else if (alertObj.type == 'part') {
			Chat.addMessage({message: alertObj.user + " has left the chat"});
		} else if (alertObj.type == 'kickban') {
			Chat.addMessage({message: alertObj.user + " was kickbanned"});
		}
	}

};
