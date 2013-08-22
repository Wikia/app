var logger = require('./logger').logger;

var RedisStorage = function() {
	this.config = require("./server_config.js"); // our node-chat config
	this.models = require('./models/models');
	this._redis = require('redis');
	this._rc = this._redis.createClient(this.config.REDIS_PORT, this.config.REDIS_HOST);
	this._rc.on('error', this.onError);
};

RedisStorage.prototype = {
	onError: function(err) {
		logger.error(err);
	},
	
	_redisCallback: function(err, result, callback, errorMsg, errback, both, processResult) {
		if (err) {
			if (typeof errorMsg == 'string') {
				errorMsg = errorMsg.replace('%error%', err);
				logger.error(errorMsg);
			}
			if (typeof errback == "function")
				errback((errorMsg) ? errorMsg : err);
		} else {
			if (typeof processResult == "function") result = processResult(result);
			if (typeof callback == "function") callback(result);
		}
		if (typeof both == "function") both(result);
	},
	
	getListOfRooms: function(cityId, type, users, callback, errback) {
		logger.debug("GET list of rooms");
		var self = this;
		var keyForListOfRooms = this.config.getKey_listOfRooms(cityId, type, users);
		var errorMsg = 'Warning: while getting rooms for cityId "'+ cityId + '": %error%';
		self._llen(keyForListOfRooms, function(numRooms) {
			if (numRooms && (numRooms != 0)) {
				logger.debug("Found " + numRooms + " rooms on wiki with city '" + cityId + "'...");
				self._lrange(keyForListOfRooms, 0, 1, callback, errorMsg, errback);
			} else {
				logger.warning("Warning: First room not found even though there were rooms a moment ago for cityId: " + cityId);
				errback();
			}
			
		}, errorMsg, errback);
	},
		
	createChatRoom: function(cityId, extraDataString, type, users, callback, errback) {
		var self = this;
		self._incr(
			self.config.getKey_nextRoomId(), function(roomId) {
				// Create the room.
				var roomKey = self.config.getKey_room( roomId );
				var extraData = {};
				if(extraDataString){
					try{
						extraData = JSON.parse( extraDataString );
					} catch(e){
						logger.error("Error: while parsing extraDataString. Error is: ", e);
						extraData = {};
					}
				}
				// Store the room in redis.
				self._hmset(roomKey, {
					'room_id': roomId,
					'wgCityId': cityId,
					'wgServer': extraData.wgServer,
					'wgArticlePath': extraData.wgArticlePath
				});

				// Add the room to the list of rooms on this wiki.
				self._rpush(self.config.getKey_listOfRooms(cityId, type, users), roomId);
				var result = {
					'roomId': roomId
				};
				// todo: analize the code below, because the success callback
				// is called and then in an asynchronous way errorCallback
				// can be called several times
				callback(result);
				if(type == 'private') {
					for(var index in users) {
						self._hset( self.config.getKey_usersAllowedInPrivRoom( roomId ),
							users[index], users[index], null,
							'Error: when save users list of chat room "'+ cityId + '": %error%',
							function(errorMsg) {
								errback(errorMsg);
								return true;
							}
						);
					}
				}
			},
			'Error: while getting length of list of rooms for wiki with cityId "'+ cityId + '": %error%',
			errback
		);
	},
	
	getRoomData: function(roomId, key, callback, errback) {
		var roomKey = this.config.getKey_room(roomId);
		if ( key === null )  {
			this._hgetall(roomKey, callback,
				"Warning: couldn't get hash data for room w/key '"+ roomKey + "': %error%", 
				function(errorMsg){
					logger.warning(errorMsg);
					errback();
				});
		} else {
			this._hget(roomKey, key, callback, 
					'Error: while getting ' + key +' of room: "'+ roomId + '": %error%', 
					errback);
		}
	},
	
	getRuntimeStats: function(callback, errback, both) {
		this._hgetall(this.config.getKey_runtimeStats(), callback,
				'Error while getting runtime stats: %error%',
				errback, both);
	},
	
	setRuntimeStats: function(data, callback, errback) {
		this._hmset(this.config.getKey_runtimeStats(), data, callback,
				'Error while setting runtime stats: %error%',
				errback);
	},
	
	getUserCount: function(callback, errback) {
		this._hget(this.config.getKey_userCount(), 'count', callback,
				'Error while getting user count: %error%',
				errback);
	},
	
	resetUserCount: function(callback, errback) {
		this._hset(this.config.getKey_userCount(), 'count', 0, callback,
				'Error while setting user count: %error%',
				errback);
	},
	
	increaseUserCount: function(count, callback, errback) {
		this._hincrby(this.config.getKey_userCount(), 'count', count, callback,
				'Error while increasing user count: %error%',
				errback);
	},
	
        purgeAllMembers: function(callback, errback) {
                var self = this;
                self._keys(self.config.getKeyPrefix_usersInRoom()+":*", function(data) {
                        _.each(data, function(usersInRoomKey) {
                                var parts = usersInRoomKey.split(':');
                                var roomId = parts[1];
                                self.getRoomData(roomId, 'wgCityId', function(wgCityId) {
                                        if(self.config.validateConnection(wgCityId)) {
                                                logger.debug("\tCleaning users out of room with key: " + usersInRoomKey);
                                                self._del(usersInRoomKey, self._redis.print, null, self._redis.print);
                                                logger.debug("\tCleaning users out of room with key: " + usersInRoomKey);
                                        } else {
                                                logger.debug("\tNot cleaning users out of room with key: " + usersInRoomKey);
                                        }
                                });
                        });
                },
                'Error: while trying to get all room membership lists: %error%',
                errback);
        },
	
	getUsersAllowedInPrivateRoom: function(roomId, callback, errback) {
		this._hkeys(this.config.getKey_usersAllowedInPrivRoom(roomId), callback,
				'Error while getting users allowed in private room ' + roomId + ' %error%',
				errback);
	},
	
	countUsersInRoom: function(roomId, callback, errback) {
		this._hlen(this.config.getKey_usersInRoom(roomId), callback,
				'Error while couting users in room ' + roomId + ' %error%',
				errback);		
	},
	
	getUsersInRoom: function(roomId, callback, errback, both) {
		var self = this;
		self._hgetall(self.config.getKey_usersInRoom( roomId ), callback,
			'Error while trying to find members of room ' + roomId + ' : %error%', 
			errback, both, 
			function(usernameToData) {
				if (usernameToData) {
				    for (var userName in usernameToData) {
				    	usernameToData[userName] = new self.models.User( JSON.parse(usernameToData[userName]));
				    }
				}
			    return usernameToData;
			}
		);
	},
	
	getUserData: function(roomId, user, callback, errback, both) {
		this._hget(this.config.getKey_usersInRoom(roomId), user, callback,
			'Error while getting user ' + user + ' data for room ' + roomId +' : %error%',
			errback, both, 
			function(userData) {
				return JSON.parse( userData );
			}
		);
	},
	
	setUserData: function(roomId, user, userData, callback, errback, both) {
		this._hset(this.config.getKey_usersInRoom(roomId), user, JSON.stringify(userData), callback,
				'Error while setting user ' + user + ' data for room ' + roomId +' : %error%',
				errback, both);
	},
	
	removeUserData: function(roomId, user, callback, errback) {
		this._hdel(this.config.getKey_usersInRoom(roomId), user, callback,
				'Error while trying to remove user ' + user + ' from room ' + roomId + ' : %error%',
				errback);
	},
	
	deleteChatRoomEntries: function(roomId, callback, errback, both) {
		this._del(this.config.getKey_chatEntriesInRoom(roomId), callback,
				'Error while removing chat entries in room ' + roomId + ' %error%',
				errback, both);
	},
	
	getChatRoomEntries: function(roomId, start, end, callback, errback, both) {
		this._lrange(this.config.getKey_chatEntriesInRoom(roomId), start, end, callback, 
				'Error while loading chat room ' + roomId + ' entries: %error%',
				errback, both);
	},
	
	getNextChatEntryId: function(callback, errback, both) {
		this._incr('next.chatentry.id', callback,
				'Error while getting next char entry id: %error%',
				errback, both);
	},
	
	addChatEntry: function(roomId, data, callback, errback, both) {
		var self = this;
		self._rpush(self.config.getKey_chatEntriesInRoom(roomId), data, function(result) {
			if (typeof callback == "function") callback(result);
			self._expire(self.config.getKey_chatEntriesInRoom(roomId), 60*60, null, null, null);
			self._pruneExtraMessagesFromRoom(roomId);
		},
		'Error while adding chat entry for room ' + roomId + ' : %error%',
		null, both);
	},
	
	getRoomState: function(roomId, both) {
		var self = this;
		var nodeChatModel = new self.models.NodeChatModel();
		
		self.getChatRoomEntries(roomId, (-1 * self.config.NUM_MESSAGES_TO_SHOW_ON_CONNECT), -1,
		function(data) {
			if (data) {
				_.each(data, function(jsonChat) {
					var chatEntry = new self.models.ChatEntry();
					chatEntry.mport(jsonChat);
					nodeChatModel.chats.add(chatEntry);
				});
				logger.debug('Revived ' + nodeChatModel.chats.length + ' chats');
			} else {
				logger.debug('No data returned for key');
			}
		},
		null,
		function() {
			// Load the initial userList - called after getChatRoomEntries callback
			logger.debug("Finding members of roomId " + roomId);
			self.getUsersInRoom(roomId, function(usernameToUser) { 
				if(usernameToUser){
					_.each(usernameToUser, function(userModel){
						//logger.debug("Room member of " + roomId + ": ");
						//logger.debug(userModel);
						nodeChatModel.users.add(userModel);
					});
				}
				logger.debug('getUsersInRoom DONE');
			},
			null,
			function() {
				if (typeof both == "function") both(nodeChatModel);
			});
		});
	},
	
	/**
	 * To prevent the messages backlog from expanding indefinitely, we call this (currently when a message is added) to make
	 * sure we're not storing too many messages.
	 */
	_pruneExtraMessagesFromRoom: function(roomId) {
		var self = this;
		var chatEntriesInRoomKey = this.config.getKey_chatEntriesInRoom(roomId), self = this;
		self._llen(chatEntriesInRoomKey, function(len) {
			if( len > self.config.MAX_MESSAGES_IN_BACKLOG + 1 ){
				logger.debug("Found a bunch of extra messages in '" + roomId + "'.  Getting rid of the oldest " + (len - self.config.MAX_MESSAGES_IN_BACKLOG) + " of them.");
				self._rc.ltrim(chatEntriesInRoomKey, (-1 * self.config.MAX_MESSAGES_IN_BACKLOG), -1, self._redis.print);
			} else if( len == (self.config.MAX_MESSAGES_IN_BACKLOG + 1)){
				// This seems like it'd be faster than ltrim even though ltrim says it's O(N) where N is number to remove and this is O(1).
				logger.debug("Trimming extra entry from list of messages in '" + roomId + "'");
				self._rc.lpop(chatEntriesInRoomKey, self._redis.print);
			}
		}, 'Error while trying to get length of list of messages in room ' + roomId + ' : %error%');
		// Seems like this message can appear before purging :/
		logger.debug("Done pruning any old messages in room (if needed).");
	},
	
	info: function(callback, errback, both) {
		var self = this;
		this._rc.info(function(err, result) {
			self._redisCallback(err, result, callback, 
					'Error while getting info: %error%', errback, both);			
		});
	},
	
	_llen: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.llen(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_lrange: function(key, start, end, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.lrange(key, start, end, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hgetall: function(key, callback, errorMsg, errback, both, formatResult) {
		var self = this;
		self._rc.hgetall(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both, formatResult);
		});
	},
	
	_incr: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.incr(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hmset: function(key, data, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hmset(key, data, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_rpush: function(key, data, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.rpush(key, data, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hset: function(key, entryKey, entryValue, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hset(key, entryKey, entryValue, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hget: function(key, data, callback, errorMsg, errback, both, processResult) {
		var self = this;
		self._rc.hget(key, data, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both, processResult);
		});		
	},
	
	_hdel: function(key, entryKey, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hdel(key, entryKey, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_keys: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.keys(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});	
	},
	
	_hincrby: function(key, entryKey, entryValue, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hincrby(key, entryKey, entryValue, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hkeys: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hkeys(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},
	
	_hlen: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.hlen(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	},

	_expire: function(key, time, callback, errorMsg, errback, both) {
                var self = this;
                self._rc.expire(key, time, function(err, result) {
                        self._redisCallback(err, result, callback, errorMsg, errback, both);
                });
        },

	_del: function(key, callback, errorMsg, errback, both) {
		var self = this;
		self._rc.del(key, function(err, result) {
			self._redisCallback(err, result, callback, errorMsg, errback, both);
		});
	}
};

var redisStorage = null;

exports.redisFactory = function() {
	if (!redisStorage) {
		redisStorage = new RedisStorage();
	}
	return redisStorage;
};
