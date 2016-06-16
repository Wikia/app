/**
 * Controllers
 */
(function () {
	'use strict';

	var NodeChatSocketWrapper,
		NodeRoomController,
		NodeChatController;

	NodeChatSocketWrapper = window.NodeChatSocketWrapper = $.createClass(window.Observable, {
		connected: false,
		firstConnected: false,
		autoReconnect: true,
		isInitialized: false,
		comingBackFromAway: false,
		roomId: false,
		socket: false,
		constructor: function (roomId) {
			NodeChatSocketWrapper.superclass.constructor.apply(this, arguments);
			this.roomId = roomId;
			this.wikiId = window.wgCityId;
		},

		send: function ($msg) {
			$().log($msg, 'message');
			if (this.socket) {
				this.socket.emit('message', $msg);
			}
		},

		connect: function () {
			// Global vars from env
			var url = 'http://' + window.wgChatHost + ':' + window.wgChatPort;
			$().log(url, 'Chat server');
			console.log('connecting to url: ' + url);

			if (this.socket) {
				if (this.socket.connected) {
					return true;
				} else {
					this.socket.removeAllListeners('message');
					this.socket.removeAllListeners('connect');
					this.socket.removeAllListeners('connect_failed');
				}
			}
			this.authRequestWithMW(function (data) {
				var socket = window.io.connect(url, {
						'force new connection': true,
						'try multiple transports': true,
						'connect timeout': false,
						'query': data,
						'max reconnection attempts': 8,
						'reconnect': true
					}),
					connectionFail = $.proxy(function (delay, count) {
						if (count === 8) {
							if (socket) {
								socket.disconnect();
							}
							this.fire('reConnectFail', {});
						}
					}, this);

				socket.on('message', $.proxy(this.onMsgReceived, this));
				socket.on('connect', $.proxy(function () {
					this.onConnect(socket, ['xhr-polling']);
				}, this));
				socket.on('reconnecting', connectionFail);
			});
		},

		onConnect: function (socket) {
			var initQueryCommand;

			this.socket = socket;

			if (!this.firstConnected) {
				initQueryCommand = new window.models.InitqueryCommand();

				setTimeout($.proxy(function () {
					this.socket.send(initQueryCommand.xport());
				}, this), 500);
			}

			$().log('connected.');
		},

		authRequestWithMW: function (callback) {
			$.proxy(callback, this)('name=' + encodeURIComponent(wgUserName) +
				'&key=' + window.wgChatKey +
				'&roomId=' + this.roomId +
				'&serverId=' + this.wikiId +
				'&wikiId=' + this.wikiId
			);
		},


		forceReconnect: function () {
			this.socket.disconnectSync();
			this.socket = null;
			this.connect();
		},

		onMsgReceived: function (message) {
			switch (message.event) {
				case 'disableReconnect':
					this.autoReconnect = false;
					break;
				case 'forceReconnect':
					this.forceReconnect();
					break;
				case 'initial':
					//we are 100% sure about connection
					this.firstConnected = true;
				default:
					if (this.firstConnected) {
						this.fire(message.event, message);
					}
					break;
			}
		}
	});

	NodeRoomController = window.NodeRoomController = $.createClass(window.Observable, {
		active: false,
		unreadMessage: 0,
		roomId: null,
		mainController: null,
		partTimeOuts: {},
		afterInitQueue: [],
		banned: {},
		userMain: null,
		maxCharacterLimit: 1000,
		constructor: function (roomId) {

			NodeRoomController.superclass.constructor.apply(this, arguments);

			this.afterInitQueue = [];
			$().log(this.afterInitQueue);
			this.socket = new NodeChatSocketWrapper(roomId);
			this.roomId = roomId;

			this.model = new models.NodeChatModelCS();

			this.model.room.set({
				roomId: roomId,
				unreadMessage: 0,
				isActive: this.active
			});

			// This is called any time a new message arrives in the room.
			this.model.chats.bind('add', $.proxy(function (current) {
				var data;

				if (current.get('isInlineAlert') !== true && current.get('msgType') === 'chat' && current.get('name') !== wgUserName) {
					this.unreadMessage++;
				}

				if (this.active === true) {
					this.unreadMessage = 0;
				}

				data = {
					unreadMessage: this.unreadMessage,
					isActive: this.active
				};

				this.model.room.set(data);
			}, this));

			this.socket.bind('join', $.proxy(this.onJoin, this));
			this.socket.bind('initial', $.proxy(this.onInitial, this));
			this.socket.bind('chat:add', $.proxy(this.onChatAdd, this));

			this.socket.bind('reConnectFail', $.proxy(this.onReConnectFail, this));
			this.socket.bind('part', $.proxy(this.onPart, this));
			this.socket.bind('kick', $.proxy(this.onKick, this));
			this.socket.bind('ban', $.proxy(this.onBan, this));

			this.socket.bind('logout', $.proxy(this.onLogout, this));

			this.viewDiscussion = new NodeChatDiscussion({
				model: this.model,
				el: $('body'),
				roomId: roomId
			});
			this.viewDiscussion.bind('clickAnchor', $.proxy(this.clickAnchor, this));
			this.viewDiscussion.bind('sendMessage', $.proxy(this.sendMessage, this));
			this.viewDiscussion.bind('updateCharacterCount', $.proxy(this.updateCharacterCount, this));

			//TODO: move to view ??
			$(window).focus($.proxy(function (e) {// set focus on the text input
				if ($(e.target).attr('name') !== 'message') {
					this.viewDiscussion.getTextInput().focus();
				}
			}, this));

			this.viewDiscussion.getTextInput().focus();
		},

		isMain: function () {
			return this.mainController === null;
		},

		onReConnectFail: function () {
			var chatEntry = new models.InlineAlert({
				text: mw.message('chat-user-permanently-disconnected').escaped()
			});
			this.model.chats.add(chatEntry);
		},

		onInitial: function (message) {
			var newChatEntry,
				jsonObj,
				chatEntries,
				i;

			if (!this.isInitialized) {
				_.each(this.model.chats.models, $.proxy(function (data) {
					this.model.chats.remove(data);
				}, this));

				this.model.chats.trigger('clear');
				// On first connection, just update the entire model.
				this.model.mport(message.data);

				this.isInitialized = true;
				$().log(this.isInitialized, 'isInitialized');
				if (this.isMain()) {
					newChatEntry = new models.InlineAlert({
						text: mw.message('chat-welcome-message', wgSiteName).escaped()
					});
					this.model.chats.add(newChatEntry);
				}

				this.userMain = this.model.users.findByName(wgUserName);
			} else {
				// If this is a reconnect... go through the model that was given and selectively, only add ChatEntries that were not already in the collection of chats.
				jsonObj = JSON.parse(message.data);
				chatEntries = this.model.chats;
				_.each(jsonObj.collections.chats.models, function (item, index) {
					var match = chatEntries.get(item.id),
						additionalEntry;

					if (typeof match === 'undefined') {
						$().log('Found a ChatEntry that must have occurred during reconnection. Adding it to the model...');
						additionalEntry = new models.ChatEntry();
						additionalEntry.mport(JSON.stringify(item));
						chatEntries.add(additionalEntry);
					}
				});

				// TODO: update the entire userlist (if the server went down or something, you're not going to get 'part' messages for the users who are gone).
				// See BugzId 6107 for more info & partially completed code.
				// https://wikia-inc.atlassian.net/browse/SUS-450
			}

			for (i in this.afterInitQueue) {
				this.socket.send(this.afterInitQueue[i]);
			}

			this.afterInitQueue = [];
		},

		setActive: function (status) {
			this.active = status;

			if (status) {
				this.unreadMessage = 0;
				this.model.room.set({
					unreadMessage: 0,
					isActive: true
				});
			} else {
				this.model.room.set({
					isActive: false
				});
			}
			//TODO: move it to view ???
			this.viewDiscussion.getTextInput().focus();
		},

		sendMessage: function (event) {
			var inputField,
				inputValue,
				chatEntry;

			if (this.active && event.which === 13 && !event.shiftKey) {
				inputField = $(event.target);
				inputValue = inputField.val();

				event.preventDefault();

				// Prevent empty messages or messages with too many characters
				if (inputValue.length && inputValue.length <= this.maxCharacterLimit) {
					chatEntry = new models.ChatEntry({
						roomId: this.roomId,
						name: wgUserName,
						text: inputValue
					});

					// Private message
					if (!this.isMain()) {
						if (this.afterInitQueue.length < 1 || this.model.users.length < 2) {
							this.mainController.socket.send(this.model.privateRoom.xport());
						}
						if (!this.isInitialized) {
							this.afterInitQueue.push(chatEntry.xport());
							//temp chat entry in case of slow connection time
							chatEntry.set({temp: true, avatarSrc: wgChatMyAvatarUrl});
							this.model.chats.add(chatEntry);
						} else {
							this.socket.send(chatEntry.xport());
						}
					} else {
						this.socket.send(chatEntry.xport());
					}

					inputField.val('').focus();
					$('body').removeClass('warn limit-near limit-reached');
				}
			}
		},

		updateCharacterCount: function (event) {
			var inputField = $(event.target),
				inputValue = inputField.val(),
				currentLength = inputValue.length,
				remaining = this.maxCharacterLimit - currentLength;

			// display character count if nearing limit
			$('.remaining').text(remaining);
			$('body')
				.toggleClass('warn', remaining <= 200)
				.toggleClass('limit-near', remaining <= 100)
				.toggleClass('limit-reached', remaining <= 0);
		},

		onChatAdd: function (message) {
			var newChatEntry,
				dataObj = JSON.parse(message.data);

			if (dataObj.attrs.isInlineAlert) {
				newChatEntry = new models.InlineAlert();
			} else {
				newChatEntry = new models.ChatEntry();
			}

			newChatEntry.mport(message.data);

			this.model.chats.add(newChatEntry);
			if (this.model.chats.length > 1000) {
				this.model.chats.remove(
					this.model.chats.at(0)
				);
			}
		},

		onJoin: function (message) {
			var joinedUser = new models.User(),
				connectedUser,
				newChatEntry;

			joinedUser.mport(message.data);

			if (joinedUser.get('name') === wgUserName) {
				this.userMain = joinedUser;
			}

			if (this.partTimeOuts[joinedUser.get('name')]) {
				clearTimeout(this.partTimeOuts[joinedUser.get('name')]);
				this.partTimeOuts[joinedUser.get('name')] = null;
				$().log('user rejoined clear partTimeOut');
			}

			connectedUser = this.model.users.findByName(joinedUser.get('name'));

			if (typeof connectedUser === 'undefined') {
				this.model.users.add(joinedUser);
				this.fire('afterJoin', joinedUser);

				//TODO: move it to other class
				if (this.isMain()) {
					if (joinedUser.get('name') !== wgUserName) {
						// Create the inline-alert (on client side so that we only display it if the user actually IS new to the room and not just disconnecting/reconnecting).
						newChatEntry = new models.InlineAlert({
							text: mw.message('chat-user-joined', joinedUser.get('name')).escaped()
						});
						this.model.chats.add(newChatEntry);
					}
				}

				this.disableRoom(joinedUser, false);
			} else {
				// The user is already in the room... just update them (in case they have changed).
				this.model.users.remove(connectedUser);
				this.model.users.add(joinedUser);
			}
		},

		onPart: function (message) {
			var partEvent = new models.PartEvent();

			partEvent.mport(message.data);
			if (this.partTimeOuts[partEvent.get('name')]) {
				return true;
			}
			this.partTimeOuts[partEvent.get('name')] = setTimeout(this.proxy(function () {
				this.onPartBase(partEvent);
			}), 45000);
		},

		/**
		 * we display the part message after 10 seconds to avoid flooding the channel
		 * with unnecessary part & join messages in case of refreshing chat window
		 */
		onLogout: function (message) {
			var logoutEvent = new models.LogoutEvent();

			logoutEvent.mport(message.data);
			if (this.partTimeOuts[logoutEvent.get('name')]) {
				return true;
			}
			this.partTimeOuts[logoutEvent.get('name')] = setTimeout(this.proxy(function () {
				this.onPartBase(logoutEvent.get('name'), false);
			}), 10000);
		},

		onKick: function (message) {
			var kickEvent = new models.KickEvent();

			kickEvent.mport(message.data);

			this.onKickOrBan(kickEvent, 'kicked');
		},

		onBan: function (message) {
			var kickEvent = new models.KickEvent();

			kickEvent.mport(message.data);
			if (kickEvent.get('time') === 0) {
				this.onKickOrBan(kickEvent, 'unbanned');
				this.banned[kickEvent.get('kickedUserName')] = false;
			} else {
				this.onKickOrBan(kickEvent, 'banned');
				this.banned[kickEvent.get('kickedUserName')] = true;
			}
		},

		onKickOrBan: function (kickEvent, mode) {
			var undoLink,
				newChatEntry,
				i;

			if (kickEvent.get('kickedUserName') !== wgUserName) {
				undoLink = '';
				if (this.userMain.get('isModerator') && mode === 'banned') {
					undoLink = ' (<a href="#" data-type="ban-undo" data-user="' +
						mw.html.escape(kickEvent.get('kickedUserName')) + '" >' +
						mw.message('chat-ban-undolink').escaped() + '</a>)';
				}

				this.onPartBase(kickEvent.get('kickedUserName'), true);

				newChatEntry = new models.InlineAlert({
					text: mw.message(
						'chat-user-was-' + mode,
						kickEvent.get('kickedUserName'),
						kickEvent.get('moderatorName')
					).rawParams([undoLink]).escaped()
				});

				this.model.chats.add(newChatEntry);
			} else {
				newChatEntry = new models.InlineAlert({
					text: mw.message('chat-you-were-' + mode, kickEvent.get('moderatorName')).escaped()
				});
				this.model.chats.add(newChatEntry);
				this.model.room.set({
					blockedMessageInput: true
				});

				while (this.model.users.models[0]) {
					this.model.users.remove(this.model.users.models[0]);
				}

				for (i in this.chats.privates) {
					this.chats.privates[i].model.room.set({
						hidden: true
					});
				}

				this.setActive(true);
				this.viewDiscussion.updateRoom(this.model.room);
			}
		},

		onPartBase: function (partedUser, skipAlert) {
			var connectedUser,
				newChatEntry;

			if (typeof partedUser !== 'string') {
				partedUser = partedUser.get('name');
			}

			connectedUser = this.model.users.findByName(partedUser);

			if (typeof connectedUser !== 'undefined') {

				//TODO: move it to other class
				if (this.isMain() && (connectedUser.get('name') !== wgUserName) && (!skipAlert)) {
					newChatEntry = new models.InlineAlert({
						text: mw.message('chat-user-parted', connectedUser.get('name')).escaped()
					});
					this.model.chats.add(newChatEntry);
				}

				this.model.users.remove(connectedUser);
				this.disableRoom(connectedUser, true);
			}
		},

		//TODO: this is wrong place for this
		disableRoom: function (user, flag) {
			var privateUser,
				roomId;

			if (this.isMain()) {
				//TODO: fix it for multiuser priv chat
				privateUser = this.model.privateUsers.findByName(user.get('name'));

				if (typeof privateUser !== 'undefined') {
					roomId = privateUser.get('roomId');

					if (typeof( this.chats.privates[roomId] ) !== 'undefined') {
						this.chats.privates[roomId].model.room.set({
							blockedMessageInput: flag
						});
					}
					//try to reconnect
					if (flag === false && this.chats.privates[roomId].model.chats.length > 0) {
						this.socket.send(this.chats.privates[roomId].model.privateRoom.xport());
					}
				}

			}
		},

		clickAnchor: function (event) {
			var target = $(event.target);

			if (target.attr('data-type') === 'ban-undo') {
				this.undoBan(target.attr('data-user'), 0, mw.message('chat-log-reason-undo').escaped());
				return true;
			}
			window.open(target.closest('a').attr('href'));
		},

		init: function () {
			this.socket.connect();
		}
	});

	NodeChatController = window.NodeChatController = $.createClass(NodeRoomController, {
		active: true,
		chats: {
			main: null,
			opens: {}, //to store more than one open chat in one window not supported yet (for now only one)
			privates: {}
		},
		activeRoom: null,
		constructor: function (roomId) {
			NodeChatController.superclass.constructor.apply(this, arguments);

			this.socket.bind('openPrivateRoom', $.proxy(this.onOpenPrivateRoom, this));
			this.socket.bind('updateUser', $.proxy(this.onUpdateUser, this));

			this.bind('afterJoin', $.proxy(this.afterJoin, this));
			this.viewUsers = new NodeChatUsers({model: this.model, el: $('body')});

			this.viewUsers.bind('showPrivateMessage', $.proxy(this.privateMessage, this));
			this.viewUsers.bind('kick', $.proxy(this.kick, this));
			this.viewUsers.bind('ban', $.proxy(this.ban, this));
			this.viewUsers.bind('giveChatMod', $.proxy(this.giveChatMod, this));


			this.viewUsers.bind('blockPrivateMessage', $.proxy(this.blockPrivate, this));
			this.viewUsers.bind('allowPrivateMessage', $.proxy(this.allowPrivate, this));

			this.viewUsers.bind('mainListClick', $.proxy(this.mainListClick, this));
			this.viewUsers.bind('privateListClick', $.proxy(this.privateListClick, this));

			this.viewUsers.bind('clickAnchor', $.proxy(this.clickAnchor, this));

			this.viewUsers.render();
			this.viewDiscussion.show();

			// Handle Away status
			//TODO: move window to view ???
			$(window)
				.mousemove($.proxy(this.resetActivityTimer, this))
				.keypress($.proxy(this.resetActivityTimer, this))
				.focus($.proxy(this.resetActivityTimer, this));

			this.chats.main = this;
			return this;
		},

		afterJoin: function (newUser) {
			var privateUser = this.model.privateUsers.findByName(newUser.get('name'));

			if (typeof privateUser === 'undefined') {
				return true;
			}

			if (typeof( this.chats.privates[privateUser.get('roomId')] ) !== 'undefined') {
				this.chats.privates[privateUser.get('roomId')].model.room.set({
					'blockedMessageInput': false
				});
			}
		},

		menuHavePrivatBlock: function (name) {
			var user = this.model.blockedUsers.findByName(name);
			$().log(this.model.blockedUsers);

			return typeof(user) === 'undefined';
		},

		mainListClick: function (obj) {
			var user = this.model.users.findByName(obj.name),
				userMain = this.model.users.findByName(wgUserName),
				userYouAreBlockedBy = this.model.blockedByUsers.findByName(obj.name),
				userPrivate = this.model.privateUsers.findByName(obj.name),
				actions = {
					regular: ['profile', 'contribs'],
					admin: []
				};

			if (this.menuHavePrivatBlock(obj.name)) {
				//	actions.push( 'private-block' );

				if (typeof(userPrivate) === 'undefined' && typeof(userYouAreBlockedBy) === 'undefined') {
					actions.regular.push('private');
				}
			} else {
				actions.regular.push('private-allow');
			}

			if (this.userMain.get('canPromoteModerator') === true && user.get('isModerator') === false) {
				actions.admin.push('give-chat-mod');
			}

			if (this.userMain.get('isModerator') === true && user.get('isModerator') === false) {
				actions.admin.push('kick');
				actions.admin.push('ban');
			}

			if (this.userMain.get('canPromoteModerator') === true &&
				user.get('isStaff') == false &&
				$.inArray('kick', actions.admin) === -1
			) {
				actions.admin.push('kick');
				actions.admin.push('ban');
			}

			this.viewUsers.showMenu(obj.target, actions);
		},

		privateListClick: function (obj) {
			var user = this.model.privateUsers.findByName(obj.name),
				actions = {
					regular: ['profile', 'contribs']
				};

			if (user.get('isStaff') === false) {
				actions.regular.push('private-block');
			}

			//, 'private-close'
			if (!this.privateMessage(obj)) {
				this.viewUsers.showMenu(obj.target, actions);
			}
		},

		showRoom: function (roomId) {
			var i;

			$().log(roomId);
			if (this.activeRoom === roomId) {
				return false;
			}

			this.activeRoom = roomId;
			if (roomId === 'main') {
				this.chats.main.setActive(true);
			} else {
				this.chats.main.setActive(false);
			}

			for (i in this.chats.privates) {
				this.chats.privates[i].setActive(i === roomId);
			}
			return true;
		},

		privateMessage: function (obj) {
			var connectedUser = false,
				userData;

			this.model.privateUsers.find(function (userEl) {
				if (userEl.get('name') === obj.name) {
					connectedUser = true;
					userData = userEl;
				}
			});

			if (connectedUser) {
				return this.showRoom(userData.get('roomId'))
			} else {
				this.openPrivateChat([obj.name]);

				return true;
			}
		},

		openPrivateChat: function (users) {
			users.push(wgUserName);
			$.ajax({
				type: 'POST',
				url: wgScript + '?action=ajax&rs=ChatAjax&method=getPrivateRoomID',
				data: {
					users: JSON.stringify(users),
					token: mw.user.tokens.get('editToken')
				},
				success: $.proxy(function (data) {
					var data = new models.OpenPrivateRoom({
						roomId: data.id,
						users: users
					});
					$().log('Attempting create private room with users ' + users.join(','));
					this.baseOpenPrivateRoom(data, true);
					this.showRoom(data.get('roomId'));
					this.chats.privates[data.get('roomId')].init();
				}, this)
			});
			this.viewUsers.hideMenu();
		},


		blockAllowPrivateAjax: function (name, dir, callback) {
			$.ajax({
				type: 'POST',
				url: wgScript + '?action=ajax&rs=ChatAjax&method=blockOrBanChat',
				data: {
					userToBan: name,
					dir: dir,
					token: mw.user.tokens.get('editToken')
				},
				success: callback
			});
		},

		blockPrivate: function (obj) {

			this.blockAllowPrivateAjax(obj.name, 'add', $.proxy(function (data) {
				var user = this.model.privateUsers.findByName(obj.name),
					userClear = new models.User({
						name: obj.name
					}),
					newChatEntry;


				this.model.blockedUsers.add(userClear);
				if (typeof(user) !== 'undefined') {
					this.chats.privates[user.get('roomId')].model.room.set({
						hidden: true
					});

					newChatEntry = new models.InlineAlert({
						text: mw.message('chat-user-blocked', wgUserName, userClear.get('name')).escaped()
					});
					this.chats.privates[user.get('roomId')].socket.send(newChatEntry.xport());

					if (this.chats.privates[user.get('roomId')].active) {
						this.chats.privates[user.get('roomId')].setActive(false);
						this.setActive(true);
					}
				}
			}, this));

			this.viewUsers.hideMenu();
		},

		allowPrivate: function (obj) {
			this.blockAllowPrivateAjax(obj.name, 'remove', $.proxy(function () {
				var privateUser = this.model.privateUsers.findByName(obj.name),
					user = this.model.blockedUsers.findByName(obj.name),
					newChatEntry;

				if (typeof(user) !== 'undefined') {
					this.model.blockedUsers.remove(user);
				}

				if (typeof(privateUser) !== 'undefined') {
					this.chats.privates[privateUser.get('roomId')].model.room.set({
						'hidden': false
					});

					newChatEntry = new models.InlineAlert({
						text: mw.message('chat-user-allow', wgUserName, privateUser.get('name')).escaped()
					});
					this.chats.privates[privateUser.get('roomId')].socket.send(newChatEntry.xport());
				}
			}, this));

			this.viewUsers.hideMenu();
		},

		// Set the current user's status to 'away' and set an away message if provided.
		setAway: function () {
			var msg = '',
				setStatusCommand = new models.SetStatusCommand({
					statusState: STATUS_STATE_AWAY,
					statusMessage: msg
				});
			$().log('Attempting to go away with message: ' + msg);
			this.socket.send(setStatusCommand.xport());
		},

		// Set the user as being back from their 'away' state (they are here again) and remove the status message.
		setBack: function () {
			var setStatusCommand;

			if (!this.comingBackFromAway) { // if we have sent this command (but just haven't finished coming back yet), don't keep spamming the server w/this command
				$().log('Telling the server that I\'m back.');
				this.comingBackFromAway = true;
				setStatusCommand = new models.SetStatusCommand({
					statusState: STATUS_STATE_PRESENT,
					statusMessage: ''
				});
				this.socket.send(setStatusCommand.xport());
			}
		},

		startActivityTimer: function () {
			this.activityTimer = setTimeout($.proxy(this.setAway, this), 5 * 60 * 1000); // the first number is minutes.
		},

		resetActivityTimer: function () {
			clearTimeout(this.activityTimer);
			this.startActivityTimer();

			// If user had been set to away, ping server to unset away.
			if ($('#ChatHeader').find('.User').hasClass('away')) {
				this.setBack();
			}
		},

		kick: function (userToKick) {
			var kickCommand = new models.KickCommand({
				userToKick: userToKick.name
			});
			$().log('Attempting to kick user: ' + userToKick);
			this.socket.send(kickCommand.xport());

			this.viewUsers.hideMenu();
		},

		ban: function (userToBan) {
			var self = this;

			$().log('Attempting to ban user: ' + userToBan);
			self.viewUsers.hideMenu();

			require(['chat-ban-modal'], function (chatBanModal) {
				chatBanModal.open(mw.message('chat-ban-modal-heading').escaped(),
					function (expires, reason) {
						var banCommand = new models.BanCommand({
							userToBan: userToBan.name,
							time: expires,
							reason: reason
						});

						self.socket.send(banCommand.xport());
					}
				);
			});
		},

		undoBan: function (name, expires, reason) {
			var newChatEntry,
				banCommand;

			if (this.banned[name]) {
				this.banned[name] = false;
				banCommand = new models.BanCommand({
					userToBan: name,
					time: expires,
					reason: reason
				});

				this.socket.send(banCommand.xport());
			} else {
				newChatEntry = new models.InlineAlert({
					text: mw.message('chat-ban-cannt-undo').escaped()
				});
				this.model.chats.add(newChatEntry);
			}
		},

		giveChatMod: function (user) {
			var giveChatModCommand = new models.GiveChatModCommand({
				userToPromote: user.name
			});
			$().log('Attempting to give chat mod to user: ' + user.name);
			this.socket.send(giveChatModCommand.xport());

			this.viewUsers.hideMenu();
		},

		onUpdateUser: function (message) {
			var updatedUser = new models.User(),
				connectedUser;

			updatedUser.mport(message.data);

			connectedUser = this.model.users.findByName(updatedUser.get('name'));

			if (typeof connectedUser !== 'undefined') {
				// Is this the right way to do it?
				this.model.users.remove(connectedUser);
				this.model.users.add(updatedUser);

				// If it was the current user who changed (and they are 'back') set them as no longer in the process of comingBackFromAway.
				if ((this.comingBackFromAway) && (connectedUser.get('name') === wgUserName) && (connectedUser.get('statusState') !== STATUS_STATE_AWAY)) {
					this.comingBackFromAway = false;
				}
			}
		},

		baseOpenPrivateRoom: function (data, active) {
			var users,
				i,
				roomData,
				privateUser;

			this.chats.privates[data.get('roomId')] = new NodeRoomController(data.get('roomId'));
			this.chats.privates[data.get('roomId')].mainController = this; //set main controller for this chat room
			this.chats.privates[data.get('roomId')].model.privateRoom = data;
			users = data.get('users');

			for (i in users) {
				if (users[i] !== wgUserName) {
					privateUser = new models.PrivateUser(this.model.users.findByName(users[i]).attributes);

					privateUser.set({
						name: users[i],
						active: active,
						roomId: data.get('roomId')
					});

					this.model.privateUsers.add(privateUser);
					roomData = {
						privateUser: privateUser
					};

					//hide blocked room for case of allow

					this.chats.privates[data.get('roomId')].model.room.set(roomData);

					break;
				}
			}
		},

		onOpenPrivateRoom: function (message) {
			var room = new models.OpenPrivateRoom(),
				users,
				i,
				blockedUser;

			room.mport(message.data);

			users = room.get('users');
			for (i = 0; i < users.length; i++) {
				if (users[i] !== wgUserName) {
					blockedUser = this.model.blockedUsers.findByName(users[i]);

					if (typeof(blockedUser) !== 'undefined' && blockedUser.get('name') === users[i]) {
						return;
					}
				}
			}

			if (typeof(this.chats.privates[room.get('roomId')]) === 'undefined') {
				this.baseOpenPrivateRoom(room, false);
			}
			this.chats.privates[room.get('roomId')].init();
		},

		init: function () {
			var newChatEntry;

			if ($.browser.msie && parseFloat(jQuery.browser.version) < 8) {
				newChatEntry = new models.InlineAlert({
					text: mw.message('chat-browser-is-notsupported').escaped()
				});
				this.model.chats.add(newChatEntry);

				return true;
			}
			$.getMessages('Chat', $.proxy(function () {
				var i, j;

				$.ajax({
					type: 'POST',
					url: window.wgScript + '?action=ajax&rs=ChatAjax&method=getPrivateBlocks',
					success: $.proxy(function (data) {
						var userClear;

						for (i in data.blockedChatUsers) {
							userClear = new models.User({
								name: data.blockedChatUsers[i]
							});
							this.model.blockedUsers.add(userClear);
						}

						for (j in data.blockedByChatUsers) {
							userClear = new models.User({
								name: data.blockedByChatUsers[j]
							});

							this.model.blockedByUsers.add(userClear);
						}
						this.socket.connect();
					}, this)
				});
			}, this));

			/*
			 * we cannot bind to unload, cos it's too late for sending the command - the socket is already closed...
			 */
			$(window).bind('beforeunload', $.proxy(function () {
				var logoutCommand = new models.LogoutCommand();
				this.socket.send(logoutCommand.xport());
			}, this));
		}
	});

	/**
	 * Bootstrap the app
	 */
	$(function () {
		if (typeof window.wgChatRoomId !== 'undefined') {
			window.mainRoom = new NodeChatController(window.wgChatRoomId);
			window.mainRoom.init();
		}
	});
})();

