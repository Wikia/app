var STATUS_STATE_PRESENT = 'here'; // strings instead of ints just for easier debugging. always use the vars, don't hardcode strings w/these states elsewhere.
var STATUS_STATE_AWAY = 'away';

(function () {
	var server = false, models;
	if (typeof exports !== 'undefined') {
		_ = require('underscore')._;
		Backbone = require('backbone');

		models = exports;
		server = true;
	} else {
		models = this.models = {};
	}

	//
	//models
	//

	models.AuthInfo = Backbone.Model.extend({
		defaults: {
			'name': '', // username, NOT trusted (comes from client) but helpful w/debugging and double check.
			'cookie': '', // the full string of cookies from the user
			'roomId': '' // the room the user is trying to get into
		}
	});

	/** Commands **/
	models.Command = Backbone.Model.extend({
		defaults: {
			'msgType': 'command', // used by the server to determine how to handle one of these objects.
			'command': ''
		}
	});

	models.OpenPrivateRoom = models.Command.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				command: 'openprivate',
				roomId: options.roomId,
				users: options.users
			});
		}
	});

	models.InitqueryCommand = models.Command.extend({
		initialize: function(){
			this.set({
				command: 'initquery'
			});
		}
	});

	models.LogoutCommand = models.Command.extend({
		initialize: function(){
			this.set({
				command: 'logout'
			});
		}
	});

	models.KickCommand = models.Command.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				command: 'kick',
				userToKick: options.userToKick
			});
		}
	});

	models.BanCommand = models.Command.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				command: 'ban',
				userToBan: options.userToBan,
				reason: options.reason,
				time: options.time
			});
		}
	});

	models.GiveChatModCommand = models.Command.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				command: 'givechatmod',
				userToPromote: options.userToPromote
			});
		}
	});

	models.SetStatusCommand = models.Command.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				command: 'setstatus',
				statusState: options.statusState,
				statusMessage: options.statusMessage
			});
		}
	});

	models.PartEvent = Backbone.Model.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				name: options.name
			});
		}
	});

	models.LogoutEvent = Backbone.Model.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				name: options.name
			});
		}
	});

	models.KickEvent = Backbone.Model.extend({
		defaults: {
			"kickedUserName": '',
			"moderatorName": '',
			"time": 0,
			"reason": ''
		},

		initialize: function(info) {
			if(!info) return;
			this.set({
				kickedUserName: info.kickedUserName,
				moderatorName: info.moderatorName,
				time: info.time ? info.time:0,
				reason: info.reason ? info.reason : ''
			});
		}
	});

	/** ChatEntries (messages, alerts) **/
	models.ChatEntry = Backbone.Model.extend({
		defaults: {
			'msgType': 'chat', // used by the server to determine how to handle one of these objects.
			'roomId' : 0,
			'name': '',
			'text': '',
			'avatarSrc': '',
			'timeStamp': '',
			'continued': false,
			'temp': false //use for long time connection with private
		}
	});

	/**
	 * Inline alerts are a special type of ChatEntry which aren't from a user and should be displayed differently (like system messages basically).
	 *
	 * If 'wfMsg' is set, then the code in wfMsg will be passed to the $.msg() i18n function and
	 * 'msgParams' will be used as the parameters.  In this case, 'text' should be left blank on the server-side because it will
	 * be used on the client-side as a cache of the output of the $.msg(wfMsg, msgParams) call. If 'text' is already filled in, then the i18n processing
	 * will be assumed to have already been done.
	 */
	models.InlineAlert = models.ChatEntry.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				isInlineAlert: true, // so that the view can detect that this should be displayed specially
				text: options.text,
				wfMsg: options.wfMsg,
				msgParams: options.msgParams
			});
		}
	});


	var modelInit = function() {
		this.chats = new models.ChatCollection();
		this.users = new models.UserCollection();
		this.privateUsers = new models.UserCollection();
		this.blockedUsers = new models.UserCollection();
		this.blockedByUsers = new models.UserCollection();

		this.chats.bind('add', function(current) {
			var last = this.at(this.length - 2),
				// assume that each message is a separate one, if not, override this prop below.
				continued = false;

			if (typeof(last) == 'object' &&
				last.get('name') == current.get('name') &&
				last.get('temp') == current.get('temp') &&
				current.get('msgType') == 'chat')
					{
						continued = true;
					}

			current.set({'continued': continued});

			this.trigger('afteradd', current);
		});

		this.chats.bind('remove', function(current) {
			current.set({'continued': false });
		});
	};

	models.NodeChatModel = Backbone.Model.extend({
		defaults: {
			"clientId": 0
		},

		initialize: function() {
			modelInit.apply(this,arguments);
		}
	});

	models.NodeChatModelCS = models.NodeChatModel.extend({
		initialize: function() {
			modelInit.apply(this,arguments);
			this.room = new models.ChatRoom();
		}
	});

	models.User = Backbone.Model.extend({
		defaults: {
			'name': '',
			'since': '',
			'statusMessage': '',
			'statusState': STATUS_STATE_PRESENT,
			'isModerator': false,
			'isStaff': false,
			'canPromoteModerator': false,
			'avatarSrc': "http://placekitten.com/50/50",
			'editCount': '?',
			'isPrivate': false,
			'active': false,
			'privateRoomId': false
		},

		initialize: function(options){

		}
	});

	models.PrivateUser = models.User.extend({
		initialize: function(options){
			if(!options) return;
			this.set({
				privateRoomId: options.privateRoomId,
				isPrivate: true
			});
		}
	});

	models.ChatRoom = Backbone.Model.extend({
		defaults: {
			'roomId': 0,
			'unreadMessage': 0,
			'blockedMessageInput': false,
			'isActive': false,
			'privateUser': false
		}
	});

	//
	//Collections
	//

	models.ChatCollection = Backbone.Collection.extend({
		model: models.ChatEntry
	});

	var findByName = function(name) {
		return this.find(function(user){
			return (user.get('name') == name);
		});
	};

	models.UserCollection = Backbone.Collection.extend({
		model: models.User,
		initialize: function() {
			this.findByName = findByName;
		}
	});

	models.PrivateUserCollection = Backbone.Collection.extend({
		model: models.PrivateUser,
		initialize: function() {
			this.findByName = findByName;
		}
	});

	//
	//Model exporting/importing
	//

	Backbone.Model.prototype.xport = function (opt) {
		var result = {},
		settings = _({recurse: true}).extend(opt || {});

		function process(targetObj, source) {
			targetObj.id = source.id || null;
			targetObj.cid = source.cid || null;
			targetObj.attrs = source.toJSON();
			_.each(source, function (value, key) {
				// since models store a reference to their collection
				// we need to make sure we don't create a circular refrence
				if (settings.recurse) {
					if (key !== 'collection' && source[key] instanceof Backbone.Collection) {
						targetObj.collections = targetObj.collections || {};
						targetObj.collections[key] = {};
						targetObj.collections[key].models = [];
						targetObj.collections[key].id = source[key].id || null;
						_.each(source[key].models, function (value, index) {
							process(targetObj.collections[key].models[index] = {}, value);
						});
					} else if (source[key] instanceof Backbone.Model) {
						targetObj.models = targetObj.models || {};
						process(targetObj.models[key] = {}, value);
					}
				}
			});
		}

		process(result, this);

		return JSON.stringify(result);
	};


	Backbone.Model.prototype.mport = function (data, silent) {
		function process(targetObj, data) {

			targetObj.id = data.id || null;
			targetObj.set(data.attrs, {silent: silent});
			// loop through each collection
			if (data.collections) {
				_.each(data.collections, function (collection, name) {
					targetObj[name].id = collection.id;
					_.each(collection.models, function (modelData, index) {
						var newObj = targetObj[name]._add(modelData.attrs, {silent: silent});
						process(newObj, modelData);
					});
				});
			}

			if (data.models) {
				_.each(data.models, function (modelData, name) {
					process(targetObj[name], modelData);
				});
			}
		}

		try{
			process(this, JSON.parse(data) );
		} catch (e){
			if (typeof console != 'undefined') {
				console.error("Unable to parse message in mport. Data attempted to parse was: ");
				console.error(data);
				console.error("Parsing error was: ");
				console.error(e);
			} else {
				throw e;
			}
		}

		return this;
	};

})()
