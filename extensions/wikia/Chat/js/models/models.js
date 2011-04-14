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
			'cookie': '', // the full string of cookies from the user
			'roomId': '' // the room the user is trying to get into
		}
	});
	
	/** Commands **/
	models.Command = Backbone.Model.extend({
		defaults: {
			'msgType': 'command', // used by the server to determine how to handle one of these objects.
			'command': '',
		}
	});
	models.KickBanCommand = models.Command.extend({
		initialize: function(options){
			this.set({
				command: 'kickban',
				userToBan: options.userToBan
			});
		}
	});
	models.SetStatusCommand = models.Command.extend({
		initialize: function(options){
			this.set({
				command: 'setstatus',
				statusState: options.statusState,
				statusMessage: options.statusMessage
			});
		}
	});

	/** ChatEntries (messages, alerts) **/
	models.ChatEntry = Backbone.Model.extend({
		defaults: {
			'msgType': 'chat', // used by the server to determine how to handle one of these objects.
			'name': '',
			'text': '',
			'avatarSrc': ''
		}
	});
	// Inline alerts are a special type of ChatEntry which aren't from a user and should be displayed differently (like system messages basically).
	models.InlineAlert = models.ChatEntry.extend({
		initialize: function(options){
			this.set({
				isInlineAlert: true, // so that the view can detect that this should be displayed specially
				text: options.text
			});
		}
	});

	models.NodeChatModel = Backbone.Model.extend({
		defaults: {
			"clientId": 0
		},

		initialize: function() {
			this.chats = new models.ChatCollection();
			this.users = new models.UserCollection();
		}
	});

	models.User = Backbone.Model.extend({
		defaults: {
			'name': '',
			'statusState': STATUS_STATE_PRESENT,
			'statusMessage': '',
			'isModerator': false,
			'avatarSrc': "http://placekitten.com/50/50",
			'editCount': '?',
			'since': ''
		},

		initialize: function(){
		},

		isAway: function(){
			return (this.get('statusState') == STATUS_STATE_AWAY);
		}
	});

	//
	//Collections
	//

	models.ChatCollection = Backbone.Collection.extend({
		model: models.ChatEntry
	});

	models.UserCollection = Backbone.Collection.extend({
		model: models.User
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
		//console.log("DATA FROM mport:\n" + data);

		function process(targetObj, data) {
			targetObj.id = data.id || null;
			targetObj.set(data.attrs, {silent: silent});
			// loop through each collection
			if (data.collections) {
				_.each(data.collections, function (collection, name) {
					targetObj[name].id = collection.id;
					_.each(collection.models, function (modelData, index) {
						var newObj = targetObj[name]._add({}, {silent: silent});
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
			process(this, JSON.parse(data));
		} catch (e){
			if (typeof console != 'undefined') {
				console.log("Unable to parse message in mport. Data attempted to parse was: ");
				console.log(data);
				console.log("Parsing error was: ");
				console.log(e);
			} else {
				throw e;
			}
		}

		return this;
	};
	
})()