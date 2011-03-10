$(function() {
	Chat.init();
});

var Chat = {
	getCb: function() { return "&cb=" + Math.floor(Math.random()*99999); },
	init: function() {
		$(window)
			.load(function() {
				// Start longPolling
				setTimeout(Chat.longPoll, 500);
			})
			.unload(function() {
				// user parts the chat
				$.ajax({
					url: wgScript + '?action=ajax&rs=ChatAjax&method=part&chatId=' + chatId + Chat.getCb(),
					async: false
				});
			})
			.focus(function() {
				// set focus on the text input
				$("#Write").find('input[type="text"]').focus();
			});
		
		// If this user is a ChatMod, set class on body tag
		if (wgChatMod) {
			$("body").addClass("chat-mod");
		}
			
		// Inline alert the chat topic
		Chat.inlineAlert({type: 'topic'});

		// Bind submit event handler and focus on input field
		$("#Write")
			.submit(Chat.writeSubmit)
			.find('input[type="text"]').focus();
		
		// Remove my ability to kickban myself
		$("#Users").find('[data-user="' + wgUserName + '"]').find(".kickban").remove();

		// Bind kickban event
		$(".kickban").click(Chat.kickban);
			
		// Scroll chat
		Chat.scrollToBottom();		
	},

	kickban: function(event) {
		event.preventDefault();
		
		var userToBan = $(event.currentTarget).parent().attr("data-user");

		// Remove the user from the userlist immediately.
		$("#Users").find('[data-user="' + userToBan + '"]').remove();

		// Send kickban to server
		var requestObj = {
			chatId: chatId,
			userToBan: userToBan
		};
		$.get(wgScript + '?action=ajax&rs=ChatAjax&method=kickBan' + Chat.getCb(), requestObj , function(data) {
			//console.log("kickban response");
			if (data.error) {
				// Show attempted kickbanned user in user list
				$("#Users").find('[data-user="' + userToBan + '"]').show();

				alert(data.error);
			}
		});
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
				message: message
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

	longPoll: function() {
		var requestObj = {
			'chatId': chatId
		};
		$.get(wgScript + '?action=ajax&rs=ChatAjax&method=longPoll' + Chat.getCb(), requestObj, function(data) {
			if(data.rejoinNeeded){
				Chat.rejoin();
			} else {
				// Add each message to the chat
				$.each(data.messages, function(index, value) {
					Chat.addMessage({
						user: value.user,
						message: value.message
					});
				});
				
				// Handle user joins
				$.each(data.users.join, function(index, value) {
					Chat.addUser(value);
				});

				// Handle user parts
				$.each(data.users.part, function(index, value) {
					Chat.removeUser(value);
				});

				// Handle user kickbans
				var iAmKickbanned = false;
				$.each(data.users.kick, function(index, value) {
					Chat.kickbanUser(value);
					if (value == wgUserName) {
						iAmKickbanned = true;
					}
				});
				
				// Do longPoll again
				if (!iAmKickbanned) {
					Chat.longPoll();
				}
			}
		}).error(function(){
			// If there are server problems, it's better not to hammer it every couple of miliseconds.
			setTimeout(function() {
				Chat.longPoll(); // might not need to re-join.  If we do, the request will tell us that anyway.
			}, 3000);
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
			// Add user message to chat
			newChatElement = $("#Chat").find("[data-type='user'].template").clone()
				.removeClass("template")
				.find(".user").html(messageObj.user).end()
				.find(".message").html(messageObj.message).end();
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
	
	addUser: function(userData) {
		// Ensure the user isn't in the list already
		if ($("#Users").find('[data-user="' + userData.user + '"]').length == 0) {
			var newUserItem = $("#Users").find(".template").clone()
				.removeClass("template")
				.attr("data-user", userData.user)
				.prepend(userData.user)
				.appendTo("#Users ul");

			if (userData.chatmod) {
				newUserItem.addClass("chat-mod");
			}
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
	
	kickbanUser: function(user) {
		//console.log("kb: " + user);
		// Remove user from user list
		$("#Users").find('[data-user="' + user + '"]').remove();
		
		// Post alert
		Chat.inlineAlert({
			type: 'kickban',
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