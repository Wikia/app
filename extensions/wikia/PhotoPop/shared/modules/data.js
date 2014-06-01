var exports = exports || {};

define.call(exports, ['modules/settings'],function(settings){
	var Storage = my.Class({
		constructor: function(){
			Observe(this);

			if(Wikia.Platform.is('app')){

				var that = this;

				Titanium.App.addEventListener('Storage:stored', function(event){
					var value = JSON.stringify(event.value);
					that.fire('set', {key: event.key, value: value});
					that.fire({name: 'set', key: event.key}, {key: event.key, value: value});
				});

				Titanium.App.addEventListener('Storage:fetched', function(event){
					var value = (event.value != null && event.value != "")?JSON.parse(event.value):event.value;

					that.fire('get', {key: event.key, value: value});
					that.fire({name: 'get', key: event.key}, {key: event.key, value: value});
				});
			}
		},

		set: function(key, value){
			if(Wikia.Platform.is('app')){
				Titanium.App.fireEvent('Storage:set', {key: key, value: JSON.stringify(value)});
			}else{
				store.set(key, value);
				this.fire('set', {key: key, value: value});
				this.fire({name: 'set', key: key}, {key: key, value: value});
			}
		},

		get: function(key){
			if(Wikia.Platform.is('app')){
				Titanium.App.fireEvent('Storage:get', {key: key});
			}else{
				var value;
				try {
					value = store.get(key);
				} catch(err) {
					Wikia.log(err);
					value = null;
				}

				this.fire('get', {key: key, value: value});
				this.fire({name: 'get', key: key}, {key: key, value: value});
			}
		},

		remove: function(key) {
			if(Wikia.Platform.is('app'))
				Titanium.App.fireEvent('Storage:remove', {key: key});
			else{
				store.remove(key);

				this.fire('remove');
				this.fire({name: 'remove', key: key});
			}
		},

		getEvent: function(eventName, key){
			return eventName + ':' + key;
		}
	}),

	XDomainLoader = my.Class({
		_onReadCache: null,
		_id: null,

		constructor: function(loaderId){
			Observe(this);

			var that = this;

			if(Wikia.Platform.is('app')){
				that._id = loaderId || (Math.random() * Math.random()).toString();

				Titanium.App.addEventListener('XDomainLoader:complete:' + that._id, function(event){
					var needsRequest = true;

					//Android will pass undefined, iOS null, YAY for consistency!
					if(typeof event.data != 'undefined' && event.data !== null && event.data != ""){
						try{
							var data = JSON.parse(event.data);
							needsRequest = false;
						}catch(err){
							needsRequest = true;
						}
					}

					if(needsRequest && event.source == 'web'){
						alert('Error, invalid response from ' + event.url);
					}else if(needsRequest){
						that._sendRequest(event.url, event.options);
					}else{
						that.fire('success', {url: event.url, response: data});
					}
				});
			}
		},

		_sendRequest: function(url, options){
			var that = this;
			options = options || {};

			reqwest({
				url: url + ((url.indexOf('?') >= 0) ? '&' : '?') + 'callback=?',
				type: 'jsonp',
				method: options.method || 'get',
				error: function(err){
					that.fire('error', {url: url, error: err});
				},
				success: function(data){
					if(Wikia.Platform.is('app')){
						Titanium.App.fireEvent('XDomainLoader:success', {url: url, response: data, options: options, id: that._id});
					}else
						that.fire('success', {url: url, response: data});
				}
			});
		},

		load: function(url, options){
			this.fire('beforeLoad', {url: url, options: options});

			if(Wikia.Platform.is('app')){
				Titanium.App.fireEvent('XDomainLoader:load', {url: url, options: options, id: this._id});
			}else{
				this._sendRequest(url, options);
			}
		}
	});

	return {
		XDomainLoader: XDomainLoader,
		storage: new Storage()
	}
});